<?php
namespace NamespacesName\Type;

use NamespacesName\Types;
use GraphQL\Type\Definition\ObjectType;

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
                            $user = 'user';
                            $pass = 'password';
                            $dsn = "mysql:host=mysql;port=3306;dbname=name_db;";
                            $pdo = new \PDO($dsn, $user, $pass);
                            $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
                            $data = $pdo->query("SELECT * from users WHERE id = {$args['id']}");

                            return array_shift($data->fetchAll());
                        }
                    ],
                    'allUsers' => [
                        'type' => Types::listOf(Types::user()),
                        'description' => 'Список пользователей',
                        'resolve' => function () {
                            $user = 'user';
                            $pass = 'password';
                            $dsn = "mysql:host=mysql;port=3306;dbname=name_db;";
                            $pdo = new \PDO($dsn, $user, $pass);
                            $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
                            $data = $pdo->query('SELECT * from users');

                            return $data->fetchAll();
                        }
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }
}