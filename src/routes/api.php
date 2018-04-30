<?php 

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use League\Route\Http\Exception\BadRequestException;

use GraphQL\GraphQL;
use GraphQL\Schema;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

$route->get('/graphql', function(ServerRequestInterface $request, ResponseInterface $response, array $args){
    try 
    {
        $pdo = new PDO('mysql:host=mysql;dbname=name_db', 'user', 'secret');
        $res = 'Connected to MySQL';
    
    }
    catch (PDOException $e) 
    {
        var_dump('Error: ' . $e->getMessage());
        exit();
    }

    $response->getBody()->write($res);
    return $response->withStatus(202);
});
/*
$route->post('/graphql', function(ServerRequestInterface $request, ResponseInterface $response, array $args){
    /*
     * Note: To know $request and $response method used, Zend Diactoros ServerRequest Documentation.
     * $request->getQueryParams();
     **/

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
    $response->getBody()->write(json_encode($output));
    return $response->withStatus(202);
});
*/

class DB
{
    private static $pdo;
    public static function init()
    {
        $user = 'user';
        $pass = 'password';
        $dsn = "mysql:host=mysql;port=3306;dbname=name_db;";
        // Создаем PDO соединение
        self::$pdo = new PDO($dsn, $user, $pass);
        // Задаем режим выборки по умолчанию
        self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    public static function selectOne($query)
    {
        $records = self::select($query);
        return array_shift($records);
    }

    public static function select($query)
    {
        $statement = self::$pdo->query($query);
        return $statement->fetchAll();
    }

    public static function affectingStatement($query)
    {
        $statement = self::$pdo->query($query);
        return $statement->rowCount();
    }
}

class UserType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Пользователь',
            'fields' => function() {
                return [
                    'id' => [
                        'type' => Types::string(),
                        'description' => 'Идентификатор пользователя'
                    ],
                    'name' => [
                        'type' => Types::string(),
                        'description' => 'Имя пользователя'
                    ],
                    'email' => [
                        'type' => Types::string(),
                        'description' => 'E-mail пользователя'
                    ],
                    'friends' => [
                        'type' => Types::listOf(Types::user()),
                        'description' => 'Друзья пользователя',
                        'resolve' => function ($root) {
                            return DB::select("SELECT u.* from friendships f JOIN users u ON u.id = f.friend_id WHERE f.user_id = {$root->id}");
                        }
                    ],
                    'countFriends' => [
                        'type' => Types::int(),
                        'description' => 'Количество друзей пользователя',
                        'resolve' => function ($root) {
                            return DB::affectingStatement("SELECT u.* from friendships f JOIN users u ON u.id = f.friend_id WHERE f.user_id = {$root->id}");
                        }
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }
}

class QueryType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => function() {
                return [
                    'user' => [
                        'type' => Types::user(),
                        'description' => 'Возвращает пользователя по id',
                        'args' => [
                            'id' => Types::int()
                        ],
                        'resolve' => function ($root, $args) {
                            return DB::selectOne("SELECT * from users WHERE id = {$args['id']}");
                        }
                    ],
                    'allUsers' => [
                        'type' => Types::listOf(Types::user()),
                        'description' => 'Список пользователей',
                        'resolve' => function () {
                            return DB::select('SELECT * from users');
                        }
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }
}

class Types
{
    private static $query;
    private static $user;

    public static function query()
    {
        return self::$query ?: (self::$query = new QueryType());
    }

    public static function user()
    {
        return self::$user ?: (self::$user = new UserType());
    }

    public static function int()
    {
        return Type::int();
    }

    public static function string()
    {
        return Type::string();
    }

    public static function listOf($type)
    {
        return Type::listOf($type);
    }
}

$route->post('/graphql', function(ServerRequestInterface $request, ResponseInterface $response, array $args){
    try {
        
        DB::init();

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
    $response->getBody()->write(json_encode($output));
    return $response->withStatus(202);
});