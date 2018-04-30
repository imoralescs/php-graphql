<?php 

namespace NamespacesName\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use NamespacesName\Config\Config;
use NamespacesName\Config\Loaders\ArrayLoader;

class ConfigServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        'config'
    ];

    public function register() {
        //$container = $this->getContainer();

        $this->getContainer()->share('config', function() {
            $loader = new ArrayLoader([
                'app' => base_path('config/app.php'),
                'cache' => base_path('config/cache.php'),
                'db' => base_path('config/db.php'),
                // 'app' => require_once __DIR__ . '/../../config/app.php',
                // 'cache' => require_once __DIR__ . '/../../config/cache.php'
            ]);
            
            return(new Config)->load([$loader]);;
        });
    }
}