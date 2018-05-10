<?php
namespace NamespacesName\Type;

use NamespacesName\Types;
use GraphQL\Type\Definition\ObjectType;

class MutationType extends ObjectType
{
    private $pdo;

    private $hash;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;

        $config = [
            'fields' => function() {
                return [
                    'changeUserEmail' => [
                        'type' => Types::user($this->pdo),
                        'description' => 'Changing the users email address',
                        'args' => [
                            'id' => Types::nonNull(Types::int()),
                            'email' => Types::nonNull(Types::email())
                        ],
                        'resolve' => function ($root, $args) {
                            // Update user email
                            $update = $this->pdo->query("UPDATE users SET email = '{$args['email']}' WHERE id = {$args['id']}");
                            $update->execute();
                            $update->rowCount();

                            // Request and return "fresh" user data
                            $user = $this->pdo->query("SELECT * from users WHERE id = {$args['id']}");
                            $data = $user->fetchAll();
                            if (is_null($data)) {
                                throw new \Exception('No user with this id');
                            }
                            return array_shift($data);
                        }
                    ],
                    'addUser' => [
                        'type' => Types::user($this->pdo),
                        'description' => 'Add a user',
                        'args' => [
                            'user' => Types::inputUser()
                        ],
                        'resolve' => function ($root, $args) {
                            $password = "$2a$12$jWz5man/w84aqb5Tu7I7JuP8.CSo8VNN/g7spotrfD7EGIgJkA0G.";
                            
                            // Adding a new user to the database
                            $insert = $this->pdo->query("INSERT INTO users (name, email, password) VALUES ('{$args['user']['name']}', '{$args['user']['email']}', '$password')");
                            $success = $insert->execute();
                            $userId = $success ? $this->pdo->lastInsertId() : null;
                            
                            // We return the data of the newly created user from the database
                            $user = $this->pdo->query("SELECT * from users WHERE id = $userId");
                            $data = $user->fetchAll();
                            return array_shift($data); 
                        }
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }
}