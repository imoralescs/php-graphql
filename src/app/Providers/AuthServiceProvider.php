<?php 

namespace NamespacesName\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Doctrine\ORM\EntityManager;
use NamespacesName\Auth\Auth;
use NamespacesName\Auth\Hashing\Hasher;
use NamespacesName\Session\SessionStore;

class AuthServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Auth::class
    ];

    public function register() {
        $container = $this->getContainer();

        $container->share(Auth::class, function() use ($container) {
            return new Auth(
                $container->get(EntityManager::class),
                $container->get(Hasher::class),
                $container->get(SessionStore::class)
            );
        });
    }
}
