<?php 

namespace NamespacesName\Controllers\Auth;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use League\Route\RouteCollection;
use NamespacesName\Controllers\Controller;
use NamespacesName\Views\View;
use NamespacesName\Auth\Auth;
use NamespacesName\Session\Flash;

class LoginController extends Controller
{
    protected $view;

    protected $auth;

    protected $route;

    protected $flash;

    public function __construct(View $view, Auth $auth, RouteCollection $route, Flash $flash) {
        $this->view = $view;
        $this->auth = $auth;
        $this->route = $route;
        $this->flash = $flash;
    }

    public function index(RequestInterface $request, ResponseInterface $response) {
        return $this->view->render($response, 'auth/login.twig');
    }

    public function signin(RequestInterface $request, ResponseInterface $response) {
        $data = $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $attempt = $this->auth->attempt(
            $data['email'],
            $data['password']
        );

        if(!$attempt) {
            // Failed
            $this->flash->now('error', 'Could not sign you in with those details.');
            return redirect($request->getUri()->getPath());
        }

        return redirect($this->route->getNamedRoute('home')->getPath());
    }
}