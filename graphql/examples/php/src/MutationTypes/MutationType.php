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
                    'description' => 'generates a random book',
                ],
                "hello" => Type::string()
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

        $final = [
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

        return $final;
    }
}