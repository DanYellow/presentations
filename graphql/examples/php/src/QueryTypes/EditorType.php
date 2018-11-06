<?php

namespace App\QueryTypes;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

use App\Entity\Book;
use App\Entity\Author;

use App\TypeRegistry as TypeRegistry;

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
                // 'books' => Type::listOf(new Book()),
                // 'authors' => Type::listOf(new Author()),
                'creationDate' => Type::string(),
                'photo' => Type::string(),
            ],
        ];
        parent::__construct($config);
    }
}