<?php 

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use League\Route\Http\Exception\BadRequestException;

use GraphQL\GraphQL;
use GraphQL\Schema;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

// Used to run JavaScript
use Nacmartin\PhpExecJs\PhpExecJs;

$route->get('/api', function(ServerRequestInterface $request, ResponseInterface $response){
    // Retrieve data from $request. Do what you need to do and build your $content.

    // Render JavaScript array
    // $phpexecjs = new PhpExecJs();
    /* $content = $phpexecjs->evalJs("
        'red yellow blue'.split(' ')
    ");
    */
    // $response->getBody()->write(json_encode($content));

    // Render JavaScript function
    $phpexecjs = new PhpExecJs();
    $content = $phpexecjs->evalJs("
        var worlds = 'Worlds';
        const hello = 'Hello';
        function greeting(str) {
            return hello + ', ' + str + '!';
        }

        greeting(worlds);
    ");

    $response->getBody()->write(json_encode($content));

    return $response->withStatus(200);
});

$route->get('/api/{id}', function(ServerRequestInterface $request, ResponseInterface $response, array $args){
    $itemId = $args['id'];
    $requestBody = json_decode($request->getBody(), true);

    // Possibly update a record.

    $response->getBody()->write(json_encode($itemId));
    return $response->withStatus(202);
});

/*
$route->get('/api/400', function(ServerRequestInterface $request, ResponseInterface $response){
    // If we fail to bad request.
    throw new BadRequestException;
});
*/

$route->post('/graphql', function(ServerRequestInterface $request, ResponseInterface $response, array $args){
    // Note: To know $request and $response method used, Zend Diactoros ServerRequest Documentation.
    // $request->getQueryParams();

    /** 
     * Query GraphQL
     * Postman:
     *   Verb - POST
     *   Body Raw - {"query": "query { echo(message: \"Hi Worlds, GraphQL!\") }" }
     *   Response - {"data":{"echo":"You said: Hi Worlds, GraphQL!"}}
     */

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

        $schema = new Schema([
            'query' => $queryType
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
    $response->getBody()->write(json_encode($output));
    return $response->withStatus(202);
});