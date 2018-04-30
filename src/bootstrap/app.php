<?php

session_start();

// Register our composer autoloader.
require_once(__DIR__.'/../vendor/autoload.php');

// For load .env file.
try {
    // default implementation.
    //$dotenv = (new Dotenv\Dotenv(__DIR__ . '/..//'))->load();

    // using helper function base_path()
    $dotenv = (new Dotenv\Dotenv(base_path()))->load();
}
catch(Dotenv\Exception\InvalidPathException $e) {
    //
}

// Register our container.
// Container are used to register all our services provider.
// require_once __DIR__ . '/container.php';
require_once base_path('/bootstrap/container.php');

// Register our routes.
// Grabbing ours route collections.
$route = $container->get(League\Route\RouteCollection::class);

// Calling middleware before route.
require_once base_path('bootstrap/middleware.php');

// Attach route.
// require_once __DIR__ . '/../routes/web.php';
// require_once __DIR__ . '/../routes/api.php';

require_once base_path('routes/web.php');
require_once base_path('routes/api.php');

// To catch request data for validation.
try {
    // Dispatch request o response.
    $response = $route->dispatch(
        $container->get('request'),
        $container->get('response')
    );
}
catch(Exception $error) {
    $handler = new NamespacesName\Exceptions\Handler(
        $error,
        $container->get(NamespacesName\Session\SessionStore::class),
        $container->get('response'),
        $container->get(NamespacesName\Views\View::class)
    );

    $response = $handler->respond();
}