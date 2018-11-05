<?php

namespace App\QueryTypes;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class BookType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => "Book",
            'description' => "A book",
            'fields' => [
                'id' => [
                    'type' => Type::id(),
                ],
                'title' => [
                    'type' => Type::string(),
                    'description' => 'Title of the book',
                ],
                'releaseDate' => Type::string(),
                'coverImage' => Type::string(),
                'summary' => Type::string(),
            ],
        ];
        parent::__construct($config);
    }
}