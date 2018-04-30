<?php 

namespace NamespacesName\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use NamespacesName\Views\View;
use NamespacesName\Models\User;

class HomeController
{
    protected $view;

    public function __construct(View $view) {
        $this->view = $view;
    }

    public function index(RequestInterface $request, ResponseInterface $response) {

        return $this->view->render($response, 'home.twig');
    }
}