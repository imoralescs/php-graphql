<?php

return [
    'name' => getenv('APP_NAME'),
    'debug' => getenv('APP_DEBUG', false),
    'providers' => [
        'NamespacesName\Providers\AppServiceProvider',
        'NamespacesName\Providers\ViewServiceProvider',
        'NamespacesName\Providers\DatabaseServiceProvider',
        'NamespacesName\Providers\SessionServiceProvider',
        'NamespacesName\Providers\HashServiceProvider',
        'NamespacesName\Providers\AuthServiceProvider',
        'NamespacesName\Providers\FlashServiceProvider',
        'NamespacesName\Providers\CsrfServiceProvider',
        'NamespacesName\Providers\ValidationServiceProvider',
        'NamespacesName\Providers\ViewShareServiceProvider',
    ],
    'middleware' => [
        'NamespacesName\Middleware\ShareValidationErrors',
        'NamespacesName\Middleware\ClearValidationErrors',
        'NamespacesName\Middleware\Authenticate',
        'NamespacesName\Middleware\CsrfGuard'
    ]
];