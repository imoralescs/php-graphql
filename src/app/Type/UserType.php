<?php
namespace NamespacesName\Type;

use NamespacesName\Types;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class UserType
 *
 * Тип User для GraphQL
 *
 * @package App\Type
 */
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
                            $user = 'user';
                            $pass = 'password';
                            $dsn = "mysql:host=mysql;port=3306;dbname=name_db;";
                            $pdo = new \PDO($dsn, $user, $pass);
                            $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
                            $data = $pdo->query("SELECT u.* from friendships f JOIN users u ON u.id = f.friend_id WHERE f.user_id = {$root->id}");
                            
                            return $data->fetchAll();
                        }
                    ],
                    'countFriends' => [
                        'type' => Types::int(),
                        'description' => 'Количество друзей пользователя',
                        'resolve' => function ($root) {

                            $user = 'user';
                            $pass = 'password';
                            $dsn = "mysql:host=mysql;port=3306;dbname=name_db;";
                            $pdo = new \PDO($dsn, $user, $pass);
                            $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
                            $data = $pdo->query("SELECT u.* from friendships f JOIN users u ON u.id = f.friend_id WHERE f.user_id = {$root->id}");
                            
                            return $data->rowCount();
                        }
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }
}