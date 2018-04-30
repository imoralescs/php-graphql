<?php 

namespace NamespacesName\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use NamespacesName\Views\View;
use NamespacesName\Session\SessionStore;

class ClearValidationErrors
{

    protected $session;

    public function __construct(SessionStore $session) {
        $this->session = $session;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next) {
        $next = $next($request, $response);
        
        $this->session->clear('errors', 'old');

        return $next;
    }
}