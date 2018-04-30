<?php 

namespace NamespacesName\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use NamespacesName\Views\View;
use NamespacesName\Session\SessionStore;

class ShareValidationErrors
{
    protected $view;

    protected $session;

    public function __construct(View $view, SessionStore $session) {
        $this->view = $view;
        $this->session = $session;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next) {
        $this->view->share([
            'errors' => $this->session->get('errors', []),
            'old' => $this->session->get('old', []),
        ]);

        return $next($request, $response);
    }
}