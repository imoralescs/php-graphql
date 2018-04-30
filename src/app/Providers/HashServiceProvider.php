<?php 

namespace NamespacesName\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use NamespacesName\Auth\Hashing\Hasher;
use NamespacesName\Auth\Hashing\BcryptHasher;

class HashServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Hasher::class
    ];

    public function register() {
        $this->getContainer()->share(Hasher::class, function() {
            return new BcryptHasher();
        });
    }
}