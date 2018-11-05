<?php

namespace App\Service;

use GraphQL\Type\Definition\ObjectType;

// use Doctrine\ORM\EntityManager;

use GraphQL\Type\Definition\Type;

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
                    'description' => 'Type of the book',
                ],
                'releaseDate' => Type::string(),
                'coverImage' => Type::string(),
                'summary' => Type::string(),
            ],
        ]);

        $queryType = new ObjectType([
            'name' => 'Query',
            'fields' => [
                'allBooks' => [
                    // 'type' => Type::listOf(Type::string()),
                    'type' => Type::listOf($bookType),
                    'description' => 'books description',
                    'resolve' => function () {
                        // $result = $em->getRepository('App\Entity\Book')->findAll();
                        return ["book" => [
                            'id' => 1,
                            'title' => 'Truc',
                            'releaseDate' => 'Truc',
                            'coverImage' => 'Truc',
                            'summary' => 'Truc',
                        ]];
                        // return $result;
                        // return $em->getRepository('App\Entity\Book')->findAll();
                    },
                ],
            ],
        ]);

        return $queryType;
    }
}
