<?php
namespace NamespacesName\Type;

use NamespacesName\Types;
use GraphQL\Type\Definition\ObjectType;

class UserType extends ObjectType
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;

        $config = [
            'description' => 'User',
            'fields' => function() {
                return [
                    'id' => [
                        'type' => Types::string(),
                        'description' => 'User ID'
                    ],
                    'name' => [
                        'type' => Types::string(),
                        'description' => 'User Username or name'
                    ],
                    'email' => [
                        'type' => Types::string(),
                        'description' => 'User E-mail'
                    ],
                    'friends' => [
                        'type' => Types::listOf(Types::user($this->pdo)),
                        'description' => 'User friends',
                        'resolve' => function ($root) {
                            // var_dump($root);
                            // var_dump($root->id);exit;
                            $data = $this->pdo->query("SELECT u.* from friendships f JOIN users u ON u.id = f.friend_id WHERE f.user_id = {$root->id}");
                            return $data->fetchAll();
                            
                        }
                    ],
                    'countFriends' => [
                        'type' => Types::int(),
                        'description' => 'Number of friends',
                        'resolve' => function ($root) {
                            $data = $this->pdo->query("SELECT u.* from friendships f JOIN users u ON u.id = f.friend_id WHERE f.user_id = {$root->id}");
                            return $data->rowCount();
                        }
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }
}