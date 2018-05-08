<?php
namespace NamespacesName\Type;

use NamespacesName\Types;
use GraphQL\Type\Definition\ObjectType;

class QueryType extends ObjectType
{
    private $pdo;
    
    public function __construct($pdo)
    {
        $this->pdo = $pdo;

        $config = [
            'fields' => function() {
                return [
                    'user' => [
                        'type' => Types::user($this->pdo),
                        'description' => 'Returns the user by id',
                        'args' => [
                            'id' => Types::int()
                        ],
                        'resolve' => function ($root, $args) {
                            $data = $this->pdo->query("SELECT * from users WHERE id = {$args['id']}");
                            return array_shift($data->fetchAll());
                        }
                    ],
                    'allUsers' => [
                        'type' => Types::listOf(Types::user($this->pdo)),
                        'description' => 'Return a list of users',
                        'resolve' => function () {                            
                            $data = $this->pdo->query("SELECT * from users");
                            return $data->fetchAll();
                        }
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }
}