<?php 

namespace NamespacesName\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use NamespacesName\Views\View;
use NamespacesName\Auth\Auth;
use NamespacesName\Session\Flash;
use NamespacesName\Security\Csrf;

// This services allow us to share services through all templates.
class ViewShareServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    public function boot() {
        $container = $this->getContainer();

        $container->get(View::class)->share([
            'config' => $container->get('config'),
            'auth' => $container->get(Auth::class),
            'flash' => $container->get(Flash::class),
            'csrf' => $container->get(Csrf::class)
        ]);
    }

    public function register() {
        
    }
}