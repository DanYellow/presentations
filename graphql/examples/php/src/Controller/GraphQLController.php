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

class GraphQLController extends AbstractController
{
    /**
     * @Route("/graphql", name="graphql")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $schema = new Schema([
            'query' => new QueryType($em),
            'mutation' => new MutationType($em),
        ]);
        $rawInput = file_get_contents('php://input');
        $input = json_decode($rawInput, true);
        $query = $input['query'];

        $variableValues = isset($input['variables']) ? $input['variables'] : null;

        try {
            $rootValue = ['prefix' => 'You said: '];
            $result = GraphQL::executeQuery($schema, $query, null, null, $variableValues);
            $output = $result;
            // $output = $result->toArray();
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
        return new JsonResponse($em->createQuery('SELECT u FROM App\Entity\Book u')->getArrayResult());
        return new JsonResponse($em->getRepository('App\Entity\Book')->findAll());
    }
}
