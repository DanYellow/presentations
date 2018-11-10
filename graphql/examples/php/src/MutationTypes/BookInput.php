<?php

namespace App\MutationTypes;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

use App\TypeRegistry;


class BookInput extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'description' => "Creates an book",
            'fields' => [
                'title' => [
                    'type' => Type::string(),
                    'description' => 'Title of the book',
                ],
                'lastName' => Type::string(),
                'summary' => Type::string(),
                // 'author' => TypeRegistry::authorInput()
            ],
        ];
        parent::__construct($config);
    }
}