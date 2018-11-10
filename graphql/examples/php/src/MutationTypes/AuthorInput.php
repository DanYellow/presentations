<?php

namespace App\MutationTypes;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

use App\TypeRegistry;


class AuthorInput extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'description' => "Creates An author",
            'fields' => [
                'firstName' => [
                    'type' => Type::string(),
                    'description' => 'Title of the book',
                ],
                'lastName' => Type::string(),
                'photo' => Type::string(),
                'books' => Type::listOf(TypeRegistry::bookInput())
            ],
        ];
        parent::__construct($config);
    }
}