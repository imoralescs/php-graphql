<?php

use Slim\Container;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\Connection;

/** @var \Slim\App $app */
// Slim Container - Is a Dependency Container, used for dependency injection.
$container = $app->getContainer();

// Activating routes in a subfolder
$container['environment'] = function () {
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $_SERVER['SCRIPT_NAME'] = dirname(dirname($scriptName)) . '/' . basename($scriptName);
    return new Slim\Http\Environment($_SERVER);
};

// Adding PDO to container
$container['pdo'] = function(Container $container) {
    $config = $container->get('settings')['pdo'];
    $dsn = "{$config['engine']}:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
    $username = $config['username'];
    $password = $config['password'];
    return new PDO($dsn, $username, $password, $config['options']);
};

// Adding Query Building to container
$container['db'] = function (Container $container) {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};