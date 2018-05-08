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
$settings['db']['host'] = 'mysql';
$settings['db']['username'] = 'user';
$settings['db']['password'] = 'password';
$settings['db']['database'] = 'name_db';
$settings['db']['charset'] = 'utf8';
$settings['db']['collation'] = 'utf8_unicode_ci';

// PDO settings
$settings['pdo']['engine'] = 'mysql';
$settings['pdo']['host'] = 'mysql';
$settings['pdo']['username'] = 'user';
$settings['pdo']['password'] = 'password';
$settings['pdo']['database'] = 'name_db';
$settings['pdo']['charset'] = 'utf8';
$settings['pdo']['collation'] = 'utf8_unicode_ci';
$settings['pdo']['options'] = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_EMULATE_PREPARES   => true,
];

return $settings;