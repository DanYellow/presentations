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
     * @Route("/__graphql", name="graphql")
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
     * @Route("/__doctrine", name="doctrine")
     */
    public function doctrine() {
        $em = $this->getDoctrine()->getManager();

        $faker = Faker::create();
        $date = new \DateTime();

        $newEditor = new Editor();
        $newEditor->setName($faker->name);
        $newEditor->setPhoto($faker->name);
        $newEditor->setCreationDate($date);

        $em->persist($newEditor);
        $em->flush();

        $strDate = $date->format('Y-m-d');

        $response = [
            'id' => $newEditor->getId(),
            'name' => $newEditor->getName(),
            'photo' => $newEditor->getPhoto(),
            'creationDate' => '$strDate',
        ];

        return new JsonResponse($response);
    }
}
