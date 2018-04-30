<?php 

//Inject dependecy for service provider

$container = new League\Container\Container;

$container->delegate(
    new League\Container\ReflectionContainer
);

$container->addServiceProvider(new NamespacesName\Providers\ConfigServiceProvider());

foreach($container->get('config')->get('app.providers') as $provider) {
    $container->addServiceProvider($provider);
}