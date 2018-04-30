<?php 
/*
@category   Framework
@package    
@author     Israel Morales
@copyright  2018 Israel Morales
@usage      For more information visit 
@license    https://github.com/blob/master/LICENSE
@version    v1.0.0
@since      01/12/18
*/
namespace NamespacesName\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\RouteCollection;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

class AppServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        RouteCollection::class,
        'response',
        'request',
        'emitter',
        'test'
    ];

    public function register() {
        $container = $this->getContainer();

        $container->share('test', function() {
            return 'it works!';
        });

        // Register our route collections.
        $container->share(RouteCollection::class, function() use ($container) {
            return new RouteCollection($container);
        });

        // Response.
        $container->share('response', Response::class);

        // Request.
        $container->share('request', function() {
            return ServerRequestFactory::fromGlobals(
                $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
            );
        });

        // Help for emit all request through app.
        $container->share('emitter', SapiEmitter::class);
    }
}