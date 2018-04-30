<?php 

namespace NamespacesName\Session;

use NamespacesName\Session\SessionStore;

class Session implements SessionStore
{
    // Getting values from session.
    public function get($key, $default = null) {
        if($this->exists($key)) {
            return $_SESSION[$key];
        }

        return $default;
    }

    // Setting values to session.
    public function set($key, $value = null) {
        if(is_array($key)) {
            foreach($key as $sessionKey => $sessionValue) {
                $_SESSION[$sessionKey] = $sessionValue;
            }
            return;
        }

        $_SESSION[$key] = $value;
    }

    // Check if session value exist.
    public function exists($key) {
        return isset($_SESSION[$key]) && !empty($_SESSION[$key]);
    }

    // Clearing session values.
    public function clear(...$key) {
        foreach($key as $sessionKey) {
            unset($_SESSION[$sessionKey]);
        }
    }
}