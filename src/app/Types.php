<?php

namespace NamespacesName;

use NamespacesName\Type\QueryType;
use NamespacesName\Type\MutationType;
use NamespacesName\Type\UserType;
use NamespacesName\Type\InputUserType;
use NamespacesName\Type\Scalar\EmailType;
use GraphQL\Type\Definition\Type;
use PDO;

class Types
{
    private static $query;

    private static $mutation;
    
    private static $user;

    private static $inputUser;

    private static $emailType;

    public static function query() {
        return self::$query ?: (self::$query = new QueryType());
    }

    public static function mutation() {
        return self::$mutation ?: (self::$mutation = new MutationType());
    }

    public static function user() {
        return self::$user ?: (self::$user = new UserType());
    }

    public static function inputUser() {
        return self::$inputUser ?: (self::$inputUser = new InputUserType());
    }

    public static function int() {
        return Type::int();
    }

    public static function string() {
        return Type::string();
    }

    public static function listOf($type) {
        return Type::listOf($type);
    }

    public static function nonNull($type) {
        return Type::nonNull($type);
    }

    public static function email() {
        return self::$emailType ?: (self::$emailType = new EmailType());
    }
}