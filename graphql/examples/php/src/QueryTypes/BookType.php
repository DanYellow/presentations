<?php

namespace App\QueryTypes;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

use App\TypeRegistry;

class BookType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => "Book",
            'description' => "A book",
            'fields' => function() {
                return [
                    'id' => [
                        'type' => Type::id(),
                    ],
                    'title' => [
                        'type' => Type::string(),
                        'description' => 'Title of the book',
                        'defaultValue' => "50 shades of Grey"
                    ],
                    'releaseDate' => Type::string(),
                    'coverImage' => Type::string(),
                    'summary' => Type::string(),
                    'author' => TypeRegistry::author()
                ];
            }
        ];
        parent::__construct($config);
    }
}
