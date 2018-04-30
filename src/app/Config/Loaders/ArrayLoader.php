<?php 

namespace NamespacesName\Config\Loaders;

use Exception;
use NamespacesName\Config\Loaders\Loader;

class ArrayLoader implements Loader
{
    protected $files;

    public function __construct(array $files) {
        $this->files = $files;
    }

    public function parse() {
        $parsed = [];

        foreach($this->files as $namespace => $path) {
            try {
                $parsed[$namespace] = require $path;
            }
            catch(Exception $e) {
                //
            }
        }

        return $parsed;
    }
}