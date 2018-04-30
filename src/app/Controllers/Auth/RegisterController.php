<?php 

namespace NamespacesName\Controllers\Auth;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use League\Route\RouteCollection;
use Doctrine\ORM\EntityManager;
use NamespacesName\Controllers\Controller;
use NamespacesName\Views\View;
use NamespacesName\Auth\Auth;
use NamespacesName\Session\Flash;
use NamespacesName\Models\User;
use NamespacesName\Auth\Hashing\Hasher;

class RegisterController extends Controller
{
    protected $view;

    protected $hash;

    protected $route;

    protected $db;

    protected $auth;

    public function __construct(View $view, Hasher $hash, RouteCollection $route, EntityManager $db, Auth $auth) {
        $this->view = $view;
        $this->hash = $hash;
        $this->route = $route;
        $this->db = $db;
        $this->auth = $auth;
    }

    public function index(RequestInterface $request, ResponseInterface $response) {
        return $this->view->render($response, 'auth/register.twig');
    }

    public function register(RequestInterface $request, ResponseInterface $response) {
        $data = $this->validateRegistration($request);
        $user = $this->createUser($data);

        // Set on session user after register or create account. Using same request data.
        if(!$this->auth->attempt($data['email'], $data['password'])) {
            return redirect('/');
        }

        return redirect($this->route->getNamedRoute('home')->getPath());
    }

    protected function createUser($data) {
        $user = new User;
        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            // Hash password
            'password' => $this->hash->create($data['password'])
        ]);
        
        $this->db->persist($user);
        $this->db->flush();

        return $user;
    }

    protected function validateRegistration(RequestInterface $request) {
        return $this->validate($request, [
            // 'exists' is a validation we create, code on ValidationServiceProvider
            'email' => ['required', 'email', ['exists', User::class]],
            'name' => ['required'],
            'password' => ['required'],
            'password_confirmation' => ['required', ['equals', 'password']]
        ]);
    }
}