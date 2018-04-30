<?php

namespace NamespacesName\Exceptions;

use Exception;
use ReflectionClass;
use Psr\Http\Message\ResponseInterface;
use NamespacesName\Session\SessionStore;
use NamespacesName\Views\View;

class Handler
{
    protected $exception;

    protected $session;

    protected $view;

    protected $response;

    public function __construct(Exception $exception, SessionStore $session, ResponseInterface $response, View $view) {
        $this->exception = $exception;
        $this->session = $session;
        $this->response = $response;
        $this->view = $view;
        
    }

    public function respond() {
        $class = (new ReflectionClass($this->exception))->getShortName();

        if(method_exists($this, $method = "handle{$class}")) {
            return $this->{$method}($this->exception);
        }

        return $this->unhandledException($this->exception);
    }

    protected function handleValidationException(Exception $error) {
        // Session set.
        $this->session->set([
            'errors' => $error->getErrors(),
            'old' => $error->getOldInput()
        ]);
        
        // Redirect.
        return redirect($error->getPath());
    }

    protected function handleCsrfTokenException(Exception $error) {
        return $this->view->render($this->response, 'errors/csrf.twig');
    }

    protected function unhandledException(Exception $error) {
        throw $error;
    }
}