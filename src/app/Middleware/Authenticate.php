<?php 

namespace NamespacesName\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use NamespacesName\Auth\Auth;

class Authenticate
{
    protected $auth;

    public function __construct(Auth $auth) {
        $this->auth = $auth;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next) {
        if($this->auth->hasUserInSession()) {
            try {
                $this->auth->setUserFromSession();
            }
            catch(Exception $error) {

            }
        }

        return $next($request, $response);
    }
}