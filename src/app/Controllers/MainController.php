<?php 

namespace NamespacesName\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use GraphQL\GraphQL;
use GraphQL\Schema;
use NamespacesName\Controllers\Controller;
use NamespacesName\Types;

class MainController extends Controller
{
    public function index(Request $request, Response $response) {
        try {
            $schema = new Schema([
                'query' => Types::query()
            ]);
    
            $rawInput = file_get_contents('php://input');
            $input = json_decode($rawInput, true);
            $query = $input['query'];
    
            $result = GraphQL::executeQuery($schema, $query);
            $output = $result->toArray();
        }
        catch(\Exception $error) {
            $output = [
                'error' => [
                    'message' => $error->getMessage()
                ]
            ];
        }

        return $response->withStatus(201)
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($output, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
}