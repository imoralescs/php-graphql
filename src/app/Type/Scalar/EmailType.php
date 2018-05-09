<?php

namespace NamespacesName\Type\Scalar;

use NamespacesName\Types;
use GraphQL\Type\Definition\ScalarType;

class EmailType extends ScalarType
{
    public function serialize($value)
    {
        return $value;
    }

    public function parseValue($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Not correct E-mail');
        }
        return $value;
    }

    public function parseLiteral($valueNode)
    {
        if (!filter_var($valueNode->value, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Not correct E-mail');
        }
        return $valueNode->value;
    }
}