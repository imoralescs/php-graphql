<?php 

namespace NamespacesName\Session;

interface SessionStore
{
    public function get($key, $default = null);

    public function set($key, $value = null);

    public function exists($key);

    public function clear(...$key);
}