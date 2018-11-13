<?php

namespace App\QueryTypes;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

use App\Entity\Book;
use App\Entity\Author;

use App\TypeRegistry;

class EditorType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => "Editor",
            'description' => "An editor",
            'fields' => [
                'id' => [
                    'type' => Type::id(),
                ],
                'name' => [
                    'type' => Type::string(),
                    'description' => 'Editor\'s name',
                ],
                'books' => Type::listOf(TypeRegistry::book()),
                'authors' => Type::listOf(TypeRegistry::author()),
                'creationDate' => Type::string(),
                'photo' => [
                    'type' => Type::string(),
                    'defaultValue' => '',
                ]
            ],
        ];
        parent::__construct($config);
    }
}