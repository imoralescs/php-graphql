<?php 

namespace NamespacesName\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use NamespacesName\Security\Csrf;
use NamespacesName\Session\SessionStore;

class CsrfServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Csrf::class
    ];

    public function register() {
        $container = $this->getContainer();

        $container->share(Csrf::class, function() use ($container) {
            return new Csrf(
                $container->get(SessionStore::class)
            );
        });
    }
}