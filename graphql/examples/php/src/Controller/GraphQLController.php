<?php

namespace App\Controller;

use App\Service\GraphQLResolvers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use GraphQL\GraphQL;
use GraphQL\Type\Schema;

use App\Entity\Book;

class GraphQLController extends AbstractController
{
    /**
     * @Route("/graphql", name="graphql")
     */
    public function index(GraphQLResolvers $graphQLResolver)
    {
        $em = $this->getDoctrine()->getManager();

        $schema = new Schema([
            'query' => $graphQLResolver->getQuery($em)
        ]);
        $rawInput = file_get_contents('php://input');
        $input = json_decode($rawInput, true);
        $query = $input['query'];

        // $variableValues = isset($input['variables']) ? $input['variables'] : null;
        $variableValues = null;

        try {
            $rootValue = ['prefix' => 'You said: '];
            $result = GraphQL::executeQuery($schema, $query, $rootValue, null, $variableValues);
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
