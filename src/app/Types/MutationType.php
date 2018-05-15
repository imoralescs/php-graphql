<?php

namespace NamespacesName\Types;

use GraphQL\Type\Definition\ObjectType;
use NamespacesName\Types\Types;
use NamespacesName\Providers\DatabaseServiceProvider;

class MutationType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'fields' => function() {
                return [
                    'changeUserEmail' => [
                        'type' => Types::user(),
                        'description' => 'Changing the users email address',
                        'args' => [
                            'id' => Types::nonNull(Types::int()),
                            'email' => Types::nonNull(Types::email())
                        ],
                        'resolve' => function ($root, $args) {
                            // Update user email
                            DatabaseServiceProvider::update("UPDATE users SET email = '{$args['email']}' WHERE id = {$args['id']}");

                            // Request and return "fresh" user data
                            $user = DatabaseServiceProvider::selectOne("SELECT * from users WHERE id = {$args['id']}");
                            if (is_null($user)) {
                                throw new \Exception('No user with this id');
                            }
                            return $user;
                        }
                    ],
                    'addUser' => [
                        'type' => Types::user(),
                        'description' => 'Add a user',
                        'args' => [
                            'user' => Types::inputUser()
                        ],
                        'resolve' => function ($root, $args) {
                            $password = "$2a$12$jWz5man/w84aqb5Tu7I7JuP8.CSo8VNN/g7spotrfD7EGIgJkA0G.";
                            
                            // Adding a new user to the database
                            $userId = DatabaseServiceProvider::insert("INSERT INTO users (name, email, password) VALUES ('{$args['user']['name']}', '{$args['user']['email']}', '$password')");
                            
                            // We return the data of the newly created user from the database
                            return DatabaseServiceProvider::selectOne("SELECT * from users WHERE id = $userId"); 
                        }
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }
}