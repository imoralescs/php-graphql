<?php 

namespace NamespacesName\Controllers\Auth;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use NamespacesName\Auth\Auth;
use NamespacesName\Controllers\Controller;

class LogoutController extends Controller
{
    protected $auth;

    public function __construct(Auth $auth) {
        $this->auth = $auth;
    }

    public function logout(RequestInterface $request, ResponseInterface $response) {
        $this->auth->logout();

        return redirect('/');
    }
}