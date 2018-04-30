<?php

namespace NamespacesName\Auth;

use Exception;
use Doctrine\ORM\EntityManager;
use NamespacesName\Models\User;
use NamespacesName\Auth\Hashing\Hasher;
use NamespacesName\Session\SessionStore;

class Auth
{
    protected $db;

    protected $hasher;

    protected $session;

    public function __construct(EntityManager $db, Hasher $hash, SessionStore $session) {
        $this->db = $db;
        $this->hash = $hash;
        $this->session = $session;
    }

    public function logout() {
        $this->session->clear($this->key());
    }

    public function attempt($username, $password) {
        $user = $this->getByUsername($username);

        if(!$user || !$this->hasValidCredentials($user, $password)) {
            return false;
        }

        // In case we level up the value to hash the password
        // we can rehash.
        if($this->needsRehash($user)) {
            $this->rehashPassword($user, $password);
        }

        $this->setUserSession($user);

        return true;
    }

    protected function needsRehash($user) {
        return $this->hash->needsRehash($user->password);
    }

    protected function rehashPassword($user, $password) {
        $this->db->getRepository(User::class)->find($user->id)->update([
            'password' => $this->hash->create($password)
        ]);

        $this->db->flush();
    }

    public function user() {
        return $this->user;
    }

    // Second method to check is user signin.
    public function check() {
        return $this->hasUserInSession();
    }

    // Check if user is signin.
    public function hasUserInSession() {
        return $this->session->exists($this->key());
    }

    public function setUserFromSession() {
        $user = $this->getById($this->session->get($this->key()));
        
        if(!$user) {
            throw new Exception();
        }

        $this->user = $user;
    }

    protected function setUserSession($user) {
        $this->session->set($this->key(), $user->id);
    }

    protected function key() {
        return 'id';
    }

    protected function hasValidCredentials($user, $password) {
        return $this->hash->check($password, $user->password);
    }

    protected function getById($id) {
        return $this->db->getRepository(User::class)->find($id);
    }

    protected function getByUsername($username) {
        return $this->db->getRepository(User::class)->findOneBy([
            'email' => $username
        ]);
    }
}