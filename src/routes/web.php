<?php 

// Home
$route->get('/', 'NamespacesName\Controllers\HomeController::index')->setName('home');

// Collection of protecting routes
$route->group('', function($route) {
    $route->get('/dashboard', 'NamespacesName\Controllers\DashboardController::index')->setName('dashboard');

    // Log out
    $route->post('/auth/logout', 'NamespacesName\Controllers\Auth\LogoutController::logout')->setName('auth.logout');
})->middleware($container->get(NamespacesName\Middleware\Authenticated::class));

// Collection of guess routes
$route->group('', function($route) {
    // Sign in
    $route->get('/auth/signin', 'NamespacesName\Controllers\Auth\LoginController::index')->setName('auth.login');
    $route->post('/auth/signin', 'NamespacesName\Controllers\Auth\LoginController::signin');
    
    // Register
    $route->get('/auth/register', 'NamespacesName\Controllers\Auth\RegisterController::index')->setName('auth.register');
    $route->post('/auth/register', 'NamespacesName\Controllers\Auth\RegisterController::register');
})->middleware($container->get(NamespacesName\Middleware\Guest::class));