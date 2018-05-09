<?php

$settings = [];

// Slim settings
$settings['displayErrorDetails'] = true;
$settings['determineRouteBeforeAppMiddleware'] = true;

// Path settings
$settings['root'] = dirname(__DIR__);
$settings['temp'] = $settings['root'] . '/tmp';
$settings['public'] = $settings['root'] . '/public';

// Database settings
$settings['db']['driver'] = 'mysql';
$settings['db']['host'] = env('DB_HOST');
$settings['db']['username'] = env('DB_USERNAME');
$settings['db']['password'] = env('DB_PASSWORD');
$settings['db']['database'] = env('DB_DATABASE');
$settings['db']['charset'] = 'utf8';
$settings['db']['collation'] = 'utf8_unicode_ci';

// PDO settings
$settings['pdo']['engine'] = 'mysql';
$settings['pdo']['host'] = env('DB_HOST');
$settings['pdo']['username'] = env('DB_USERNAME');
$settings['pdo']['password'] = env('DB_PASSWORD');
$settings['pdo']['database'] = env('DB_DATABASE');
$settings['pdo']['charset'] = 'utf8';
$settings['pdo']['collation'] = 'utf8_unicode_ci';
$settings['pdo']['options'] = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_EMULATE_PREPARES   => true,
];

return $settings;