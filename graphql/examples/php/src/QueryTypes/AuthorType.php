<?php

namespace App\QueryTypes;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

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
                // 'summary' => Type::string(),
            ],
        ];
        parent::__construct($config);
    }
}