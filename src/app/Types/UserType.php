<?php

namespace NamespacesName\Types;

use GraphQL\Type\Definition\ObjectType;
use NamespacesName\Types\Types;
use NamespacesName\Providers\DatabaseServiceProvider;

class UserType extends ObjectType
{
    public function __construct()
    {
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
                        'type' => Types::listOf(Types::user()),
                        'description' => 'User friends',
                        'resolve' => function ($root) {
                            // var_dump($root);
                            // var_dump($root->id);exit;
                            return DatabaseServiceProvider::select("SELECT u.* from friendships f JOIN users u ON u.id = f.friend_id WHERE f.user_id = {$root->id}");
                            
                        }
                    ],
                    'countFriends' => [
                        'type' => Types::int(),
                        'description' => 'Number of friends',
                        'resolve' => function ($root) {
                            return DatabaseServiceProvider::affectingStatement("SELECT u.* from friendships f JOIN users u ON u.id = f.friend_id WHERE f.user_id = {$root->id}");
                        }
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }
}