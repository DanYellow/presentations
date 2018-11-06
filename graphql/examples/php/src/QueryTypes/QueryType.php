<?php

namespace App\QueryTypes;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

use App\QueryTypes\BookType;
use App\QueryTypes\AuthorType;
use App\QueryTypes\EditorType;

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
                    'description' => 'Returns stuffs',
                    "args" => [
                        "id" => Type::id(),
                    ]
                ],
                'allAuthors' => [
                    'type' => Type::listOf(TypeRegistry::author()),
                    'description' => 'Returns authors',
                    "args" => [
                        "lastName" => Type::string(),
                        "firstName" => Type::string(),
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
        return $final;
    }

    public function allAuthors()
    {
        $result = $this->em->getRepository('App\Entity\Author')->findAll();
        $final = [];
        foreach($result as $val) {
            array_push($final, [
                'id' => $val->getId(),
                'firstName' => $val->getFirstName(),
                'lastName' => $val->getLastName(),
                'photo' => $val->getPhoto()
            ]);
        }
        return $final;
    }
}