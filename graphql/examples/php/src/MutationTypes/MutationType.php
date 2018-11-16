<?php

namespace App\MutationTypes;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

use Faker\Factory as Faker;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Editor;

use App\TypeRegistry;


class MutationType extends ObjectType
{
    private $em;
    private $faker;

    public function __construct($em)
    {
        $this->em = $em;
        $this->faker = Faker::create();

        $config = [
            "name" => "Mutation",
            "fields" => [
                'generateBook' => [
                    'type' => TypeRegistry::book(),
                    'description' => 'Generates a random book',
                ],
                'createEditor' => [
                    'type' => TypeRegistry::editor(),
                    'description' => 'Creates an editor',
                    "args" => [
                        "editor" => Type::nonNull(TypeRegistry::editorInput()),
                    ]
                ],
                'createAuthor' => [
                    'type' => TypeRegistry::author(),
                    'description' => 'Creates an author',
                    "args" => [
                        "author" => Type::nonNull(TypeRegistry::authorInput()),
                    ]
                ],
                'deleteAuthor' => [
                    'type' => TypeRegistry::author(),
                    'description' => 'Delete an author',
                    "args" => [
                        "id" => Type::nonNull(Type::id())
                    ]
                ],
                'addAuthorsToEditor' => [
                    'type' => TypeRegistry::editor(),
                    'description' => 'Adds author(s) to an editor',
                    "args" => [
                        "id" => [
                            "type" => Type::nonNull(Type::id()),
                            "description" => "Editor's id (mandatory)"
                        ],
                        "authors_id" => [
                            "type" => Type::nonNull(Type::listOf(Type::id())),
                            "description" => "Author(s) id"
                        ]
                    ]
                ],
                'hello' => Type::string()
            ],
            'resolveField' => function($val, $args, $context, ResolveInfo $info){
                return $this->{$info->fieldName}($val, $args, $context, $info);
            }
        ];
        parent::__construct($config);
    }

    public function hello()
    {
        return 'Ready to go !';
    }

    public function generateBook()
    {
        $newAuthor = new Author();
        $newAuthor->setFirstName($this->faker->firstName);
        $newAuthor->setLastName($this->faker->firstName);

        $this->em->persist($newAuthor);
        $this->em->flush();

        $newBook = new Book();
        $newBook->setTitle($this->faker->name);
        $newBook->setSummary($this->faker->text);
        $newBook->setAuthor($newAuthor);
        
        $this->em->persist($newBook);
        $this->em->flush();

        $response = [
            'id' => $newBook->getId(),
            'summary' => $newBook->getSummary(),
            'title' => $newBook->getTitle(),
            'coverImage' => $newBook->getCoverImage(),
            'author' => [
                'id' => $newAuthor->getId(),
                'firstname' => $newAuthor->getFirstName(),
                'lastname' => $newAuthor->getLastName(),
            ]
        ];

        return $response;
    }

    public function createAuthor($rootValue, $args) {
        $newAuthor = new Author();
        $newAuthor->setFirstName($args['author']["firstName"]);
        $newAuthor->setLastName($args['author']["lastName"]);

        $this->em->persist($newAuthor);
        $this->em->flush();

        $response = [
            'id' => $newAuthor->getId(),
            'firstName' => $newAuthor->getFirstName(),
            'lastName' => $newAuthor->getLastName(),
        ];

        return $response;
    }

    public function deleteAuthor($rootValue, $args) 
    {
        $author = $this->em->getRepository('App\Entity\Author')->findOneBy(['id' => $args['id']]);
        if(!$author) {
            return [
                "firstName" => "Not found"
            ];
        }

        $response = [
            'id' => $author->getId(),
            'firstName' => $author->getFirstName(),
            'lastName' => $author->getLastName(),
        ];

        $this->em->remove($author);
        $this->em->flush();

        return $response;
    }

    public function createEditor($rootValue, $args) 
    {
        $date = new \DateTime("now");

        $newEditor = new Editor();
        $newEditor->setName($args['editor']["name"]);
        $newEditor->setPhoto($args['editor']["photo"]);
        $newEditor->setCreationDate($date);
        
        $strDate = $date->format('Y-m-d');

        $this->em->persist($newEditor);
        $this->em->flush();

        $response = [
            'id' => $newEditor->getId(),
            'name' => $newEditor->getName(),
            'photo' => $newEditor->getPhoto(),
            'creationDate' => $strDate,
        ];

        return $response;
    }

    public function addAuthorsToEditor($rootValue, $args)
    {
        $editor = $this->em->getRepository('App\Entity\Editor')->findOneBy(['id' => $args['id']]);
    
        if(!$editor) {
            throw new Error("Editor not found");
        }

        $authors = $this->em->getRepository('App\Entity\Author')->findById($args['authors_id']);
        $authorsObj = [];
        
        foreach($authors as $author) {
            $editor->addAuthor($author);

            array_push($authorsObj, [
                'id' => $author->getId(),
                'firstName' => $author->getFirstName(),
                'lastName' => $author->getLastName(),
            ]);
        }
        
        $this->em->merge($editor);
        $this->em->flush();

        $strDate = $editor->getCreationDate()->format('Y-m-d');

        $response = [
            'id' => $editor->getId(),
            'name' => $editor->getName(),
            'photo' => $editor->getPhoto(),
            'creationDate' => $strDate,
            "authors" => $authorsObj
        ];

        return $response;
    }
}