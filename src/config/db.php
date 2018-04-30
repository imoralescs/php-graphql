<?php

return [
    'mysql' => [
        'driver'    => env('DB_DRIVER', 'pdo_mysql'),
        'host'      => env('DB_HOST', 'mysql'),
        //'host'      => env('DB_HOST', '127.0.0.1'),
        'dbname'    => env('DB_DATA', 'name_db'),
        'user'      => env('DB_USERNAME', 'user'),
        'password'  => env('DB_PASSWORD', 'password'),
        'port'      => env('DB_PORT', '3306')
    ]
];