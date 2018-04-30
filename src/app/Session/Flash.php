<?php 

namespace NamespacesName\Session;

use NamespacesName\Session\SessionStore;

class Flash
{
    protected $session;

    public function __construct(SessionStore $session) {
        $this->session = $session;
        $this->loadFlashMessagesIntoCache();
        $this->clear();
    }

    public function has($key) {
        return isset($this->messages[$key]);
    }

    public function get($key) {
        if($this->has($key)) {
            return $this->messages[$key];
        }
    }

    public function now($key, $value) {
        $this->session->set('flash', array_merge(
            $this->session->get('flash') ?? [], [$key => $value]
        ));
    }

    protected function clear() {
        $this->session->clear('flash');
    }

    public function loadFlashMessagesIntoCache() {
        $this->messages = $this->getAll();
    }

    public function getAll() {
        return $this->session->get('flash');
    }
}