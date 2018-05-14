<?php

namespace NamespacesName\Type;

use GraphQL\Type\Definition\ObjectType;
use NamespacesName\Types;
use NamespacesName\Providers\DatabaseServiceProvider;

class QueryType extends ObjectType
{    
    public function __construct()
    {
        $config = [
            'fields' => function() {
                return [
                    'user' => [
                        'type' => Types::user(),
                        'description' => 'Returns the user by id',
                        'args' => [
                            'id' => Types::int()
                        ],
                        'resolve' => function ($root, $args) {
                            return DatabaseServiceProvider::selectOne("SELECT * from users WHERE id = {$args['id']}");
                        }
                    ],
                    'allUsers' => [
                        'type' => Types::listOf(Types::user()),
                        'description' => 'Return a list of users',
                        'resolve' => function () {                            
                            return DatabaseServiceProvider::select("SELECT * from users");
                        }
                    ]
                ];
            }
        ];
        parent::__construct($config);
    }
}