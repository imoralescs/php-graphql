<?php
namespace NamespacesName\Types;

use NamespacesName\Types\Types;
use GraphQL\Type\Definition\InputObjectType;

class InputUserType extends InputObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Add a user',
            'fields' => function() {
                return [
                    'name' => [
                        'type' => Types::nonNull(Types::string()),
                        'description' => 'Username'
                    ],
                    'email' => [
                        'type' => Types::nonNull(Types::email()),
                        'description' => 'Users e-mail'
                    ],
                ];
            }
        ];
        parent::__construct($config);
    }
}