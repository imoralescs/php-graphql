<?php

namespace NamespacesName\Controllers;

use Psr\Http\Message\RequestInterface;
use Valitron\Validator;
use NamespacesName\Exceptions\ValidationException;

abstract class Controller 
{
    // Validation by vlucas/valitron
    public function validate(RequestInterface $request, array $rules) {
        $validator = new Validator($request->getParsedBody());

        $validator->mapFieldsRules($rules);

        if(!$validator->validate()) {
            throw new ValidationException(
                $request,
                $validator->errors()
            );
        }

        return $request->getParsedBody();
    }
}