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

    public function allBooks()
    {
        $result = $this->em->getRepository('App\Entity\Book')->findAll();
        $final = [];
        foreach($result as $val) {
            array_push($final, [
                'id' => $val->getId(),
                'summary' => $val->getSummary(),
                'title' => $val->getTitle(),
                'coverImage' => $val->getCoverImage()
            ]);
        }
        return [];
    }

    public function mapBook($book) {
        return [
            "title" => $book->getTitle(),
            "summary" => $book->getSummary(),
        ];
    }

    public function allAuthors($rootValue, $args)
    {
        $authors = $this->em->getRepository('App\Entity\Author')->findAll();

        if($args['firstName'] !== "" || $args['lastName'] !== "") {
            $queryParams = [
                'lastName' => '%' . $args['lastName'] . '%',
                // 'firstName' => $args['firstName'] . "%"
            ];
            if(!isset($args['firstName'])) {
                unset($queryParams['firstName']);
            }

            if(!isset($args['lastName'])) {
                unset($queryParams['lastName']);
            }

            $authors = $this->em->getRepository('App\Entity\Author')
                ->createQueryBuilder('o')
                // ->where('o.firstName = :firstname')
                ->where('o.lastName LIKE :lastName')
                ->setParameters($queryParams)
                ->getQuery()
                ->getResult();
        }

        $result = [];
        foreach($authors as $val) {
            array_push($result, [
                'id' => $val->getId(),
                'firstName' => $val->getFirstName(),
                'lastName' => $val->getLastName(),
                'photo' =>$args['lastName'],
                'books' => array_map(array($this, "mapBook"), $val->getBooks()->toArray())
            ]);
        }
        return $result;
    }
}