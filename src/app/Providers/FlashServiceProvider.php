<?php 

namespace NamespacesName\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use NamespacesName\Session\Flash;
use NamespacesName\Session\SessionStore;

class FlashServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Flash::class
    ];

    public function register() {
        $container = $this->getContainer();

        $container->share(Flash::class, function() use ($container) {
            return new Flash(
                $container->get(SessionStore::class)
            );
        });
    }
}