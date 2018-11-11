<?php

namespace App\Controller;

use App\Service\GraphQLResolvers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use GraphQL\GraphQL;
use GraphQL\Type\Schema;

use App\QueryTypes\QueryType;
use App\MutationTypes\MutationType;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Editor;

use Faker\Factory as Faker;

use GraphQL\Error\Debug;

use App\TypeRegistry;

class GraphQLController extends AbstractController
{
    /**
     * @Route("/graphql", name="graphql")
     */
    public function graphql()
    {
        $em = $this->getDoctrine()->getManager();

        try {
            $schema = new Schema([
                'query' => new QueryType($em),
                'mutation' => new MutationType($em),
            ]);
            $schema->assertValid();
        } catch (GraphQL\Error\InvariantViolation $e) {
            echo $e->getMessage();
        }
        $rawInput = file_get_contents('php://input');
        $input = json_decode($rawInput, true);
        $query = $input['query'];

        $variableValues = isset($input['variables']) ? $input['variables'] : null;

        try {
            $debug = Debug::INCLUDE_DEBUG_MESSAGE | Debug::INCLUDE_TRACE;
            $result = GraphQL::executeQuery($schema, $query, null, null, $variableValues);
            $output = $result->toArray($debug);
        } catch (\Exception $e) {
            $output = [
                'errors' => [
                    [
                        'message' => $e->getMessage()
                    ]
                ]
            ];
        }

        return new JsonResponse($output);
    }

    /**
     * @Route("/doctrine", name="doctrine")
     */
    public function doctrine() {
        $em = $this->getDoctrine()->getManager();

        $faker = Faker::create();
        $newAuthor = new Author();
        $newAuthor->setFirstName($faker->name);
        $newAuthor->setLastName($faker->name);

        $newBook = new Book();
        $newBook->setTitle($faker->name);
        $newBook->setSummary($faker->text);
        $newBook->setAuthor($newAuthor);
        
        $em->persist($newBook);
        $em->flush();

        
        $final = [
            'id' => $newBook->getId(),
            'summary' => $newBook->getSummary(),
            'title' => $newBook->getTitle(),
            'coverImage' => $newBook->getCoverImage(),
            'author' => [
                'id' => $newAuthor->getId(),
                'firstname' => $newAuthor->getFirstName(),
                'lastname' => $newAuthor->getLastName(),
            ]
        ];

        return new JsonResponse($final);
    }
}
