<?php 

namespace NamespacesName\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use GraphQL\GraphQL;
use GraphQL\Schema;
use GraphQL\Validator\DocumentValidator;
use GraphQL\Validator\Rules;
use GraphQL\Validator\Rules\QueryComplexity;
use GraphQL\Validator\Rules\QueryDepth;
use NamespacesName\Controllers\Controller;
use NamespacesName\Types\Types;
use NamespacesName\Providers\DatabaseServiceProvider;

class MainController extends Controller
{
    public function index(Request $request, Response $response) {
        
        // Calling config from container
        $config = $this->container->get('settings')['pdo'];

        DatabaseServiceProvider::init($config);
        
        try {
            $rawInput = file_get_contents('php://input');
            $input = json_decode($rawInput, true);
            $query = $input['query'];

            $variableValues = isset($input['variables']) ? $input['variables'] : null;

            $schema = new Schema([
                'query' => Types::query(),
                'mutation' => Types::mutation()
            ]);
            
            $result = GraphQL::executeQuery($schema, $query, null, null, $variableValues);
            $output = $result->toArray();
        }
        catch(\Exception $error) {
            $output = [
                'error' => [
                    'message' => $error->getMessage()
                ]
            ];
        }

        return $response->withStatus(200)
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($output, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
}