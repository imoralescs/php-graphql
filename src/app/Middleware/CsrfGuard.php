<?php 

namespace NamespacesName\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use NamespacesName\Security\Csrf;
use NamespacesName\Exceptions\CsrfTokenException;

class CsrfGuard
{
    protected $csrf;

    public function __construct(Csrf $csrf) {
        $this->csrf = $csrf;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next) {
        if(!$this->requestRequiresProtection($request)) {
            return $next($request, $response);
        }

        if(!$this->csrf->tokenIsValid($this->getTokenFromRequest($request))) {
            throw new CsrfTokenException();
        }

        return $next($request, $response);
    }

    protected function getTokenFromRequest($request) {
        return $request->getParsedBody()[$this->csrf->key()] ?? null;
    }

    protected function requestRequiresProtection($request) {
        return in_array($request->getMethod(), ['POST', 'PUT', 'DELETE', 'PATCH']);
    }
}