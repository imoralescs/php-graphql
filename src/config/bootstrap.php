<?php

require_once __DIR__ . '/../vendor/autoload.php';

// For load .env file.
try {
    $dotenv = (new Dotenv\Dotenv(base_path()))->load();
}
catch(Dotenv\Exception\InvalidPathException $e) {}

// Instantiate the app
$app = new \Slim\App(['settings' => require __DIR__ . '/../config/settings.php']);

// Set up dependencies
require  __DIR__ . '/container.php';

// Register middleware
require __DIR__ . '/middleware.php';

// Register routes
require __DIR__ . '/../routes/routes.php';

return $app;