<?php 

namespace NamespacesName\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use NamespacesName\Session\Session;
use NamespacesName\Session\SessionStore;

class SessionServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        SessionStore::class
    ];

    public function register() {
        $container = $this->getContainer();

        $container->share(SessionStore::class, function() {
            return new Session();
        });
    }
}