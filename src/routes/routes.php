<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Illuminate\Database\Connection;

use GraphQL\GraphQL;
use GraphQL\Schema;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

use NamespacesName\Controllers\MainController;

$app->get('/test', function (Request $request, Response $response) {
    $response->getBody()->write("It works!");
    return $response;
});

$app->get('/test/{param}', function (Request $request, Response $response) {
    $param = $request->getAttribute('param');
    $response->getBody()->write("It works!, param: $param");

    return $response;
});

$app->get('/databases', function (Request $request, Response $response) {
    // Normal PDO
    /*
    $pdoHandler = $this->get('pdo');
    $queryUsers = $pdoHandler->prepare("SELECT * FROM users LIMIT 100");
    $queryUsers->execute();
    
    $users = $queryUsers->fetchAll();    
    return $response->withStatus(201)
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($users, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    */

    // Using Query Building
    $queryBuildHandler = $this->get('db');
    $user = $queryBuildHandler
            ->table('users')
            ->select('id', 'name', 'email')
            ->where('id', '=', 1)
            ->first();
    
    return $response->withJson($user);
});

/*
$app->post('/graphql', function (Request $request, Response $response) {
    /** 
     * Note: To know $request and $response method used, Zend Diactoros ServerRequest Documentation.
     * $request->getQueryParams();
     */

    /** 
     * Query GraphQL
     * Postman:
     *   Verb - POST
     *   Query:
     *     Body raw - {"query": "query { echo(message: \"Hi Worlds, GraphQL!\") }"}
     *     Response - {"data":{"echo":"You said: Hi Worlds, GraphQL!"}}
     *   Mutation:
     *     Body raw - {"query": "mutation { sum(x: 2, y: 2) }"}
     *     Response - {"data":{"sum":4}}
     */
/*    
    try {
        $queryType = new ObjectType([
            'name' => 'Query',
            'fields' => [
                'echo' => [
                    'type' => Type::string(),
                    'args' => [
                        'message' => [
                            'type' => Type::string()
                        ],
                    ],
                    'resolve' => function($root, $args) {
                        return $root['prefix'] . $args['message'];
                    }
                ]
            ]
        ]);

        $mutationType = new ObjectType([
            'name' => 'Calc',
            'fields' => [
                'sum' => [
                    'type' => Type::int(),
                    'args' => [
                        'x' => ['type' => Type::int()],
                        'y' => ['type' => Type::int()],
                    ],
                    'resolve' => function ($root, $args) {
                        return $args['x'] + $args['y'];
                    },
                ],
            ],
        ]);

        $schema = new Schema([
            'query' => $queryType,
            'mutation' => $mutationType
        ]);

        $rawInput = file_get_contents('php://input');
        $input = json_decode($rawInput, true);
        $query = $input['query'];
        $variableValues = isset($input['variables']) ? $input['variables'] : null;

        $rootValue = ['prefix' => 'You said: '];
        $result = GraphQL::executeQuery($schema, $query, $rootValue, null, $variableValues);
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
});
*/

$app->post('/graphql', MainController::class . ':index');