<?php

namespace App\QueryTypes;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

use App\TypeRegistry;


class AuthorType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => "An author",
            'fields' => [
                'id' => [
                    'type' => Type::ID(),
                ],
                'firstName' => [
                    'type' => Type::string(),
                    'description' => 'Title of the book',
                ],
                'lastName' => Type::string(),
                'photo' => Type::string(),
                'books' => Type::listOf(TypeRegistry::book())
                // 'summary' => Type::string(),
            ],
        ];
        parent::__construct($config);
    }
}