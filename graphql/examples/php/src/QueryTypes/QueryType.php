<?php

namespace App\QueryTypes;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

use App\TypeRegistry;

class QueryType extends ObjectType
{
    private $em;
    
    public function __construct($em)
    {
        $this->em = $em;

        $config = [
            "name" => "Query",
            "fields" => [
                'allBooks' => [
                    'type' => Type::listOf(TypeRegistry::book()),
                    'description' => 'Returns books',
                    "args" => [
                        "title" => Type::string(),
  
                    ]
                ],
                'allAuthors' => [
                    'type' => Type::listOf(TypeRegistry::author()),
                    'description' => 'Returns authors',
                    "args" => [
                        "lastName" => [
                            'type' => Type::string(),
                            'defaultValue' => ""
                        ],
                        "firstName" => [
                            'type' => Type::string(),
                            'defaultValue' => ""
                        ],
                        "page" =>  [
                            'type' => Type::int(),
                            'defaultValue' => ""
                        ]
                    ]
                ],
                'allEditors' => [
                    'type' => Type::listOf(TypeRegistry::editor()),
                    'description' => 'Returns editors',
                    "args" => [
                        "name" => Type::string(),
                    ]
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

    public function allBooks($rootValue, $args)
    {
        $result = $this->em->getRepository('App\Entity\Book')->findAll();
        $page = $args['page'] || 1;
        $itemPerPage = 5;
        $result->setFirstResult($page * $itemPerPage)->setMaxResults($itemPerPage);

        $final = [];
        foreach($result as $val) {
            array_push($final, [
                'id' => $val->getId(),
                'summary' => $val->getSummary(),
                'title' => $val->getTitle(),
                'coverImage' => $val->getCoverImage(),
            ]);
        }
        return [];
    }

    public function mapBook($book) {
        return [
            "id" => $book->getId(),
            "title" => $book->getTitle(),
            "summary" => $book->getSummary(),
            'coverImage' => $book->getCoverImage()
        ];
    }

    public function allAuthors($rootValue, $args)
    {
        $page = $args['page'] ?: 1;
        $itemPerPage = 5;
        $dql = "SELECT a FROM App\Entity\Author a";
        $authors = $this->em->createQuery($dql)
                    ->setFirstResult($page * $itemPerPage)
                    ->setMaxResults($itemPerPage)
                    ->getResult();

        if(!empty($args['firstName']) || !empty($args['lastName'])) {
            $authors = $this->em->getRepository('App\Entity\Author')
                ->findByFirstNameOrLastName($args);
        }

        $result = [];
        foreach($authors as $val) {
            array_push($result, [
                'id' => $val->getId(),
                'firstName' => $val->getFirstName(),
                'lastName' => $val->getLastName(),
                'photo' => $val->getPhoto(),
                'books' => array_map(array($this, "mapBook"), $val->getBooks()->toArray())
            ]);
        }
        return $result;
    }
}