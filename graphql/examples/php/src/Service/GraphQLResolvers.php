<?php

namespace App\Service;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

// use Doctrine\ORM\EntityManager;

use App\Entity\Book;

class GraphQLResolvers 
{
    public function getQuery($em)
    {
        $bookType = new ObjectType([
            'name' => "Book",
            'description' => "A book",
            'fields' => [
                'id' => Type::id(),
                'title' => [
                    'type' => Type::string(),
                    'description' => 'Type of the book'
                ],
                'releaseDate' => Type::string(),
                'coverImage' => Type::string(),
                'summary' => Type::string()
            ]
        ]);
        var_dump($em->getRepository(Book::class)->findAll());
        $queryType = new ObjectType([
            'name' => 'Query',
            'fields' => [
                'books' => [
                    'type' => Type::listOf($bookType),
                    'description' => 'books description',
                    'args' => [],
                    'resolve' => function ($root, $args) {
                        return $em->getRepository(Book::class)->findAll()->getArrayResult();
                        return [];
                    }
                ],
            ],
        ]);

        return $queryType;
    }
}

