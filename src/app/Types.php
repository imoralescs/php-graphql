<?php

namespace NamespacesName;

use NamespacesName\Type\QueryType;
use NamespacesName\Type\UserType;
use GraphQL\Type\Definition\Type;

class Types
{
    /**
     * @var QueryType
     */
    private static $query;

    /**
     * @var UserType
     */
    
     private static $user;
    /**
     * @return QueryType
     */
        
    public static function query($pdo)
    {
        return self::$query ?: (self::$query = new QueryType($pdo));
    }
    
    /**
     * @return UserType
     */
    public static function user($pdo)
    {
        return self::$user ?: (self::$user = new UserType($pdo));
    }
    
    /**
     * @return \GraphQL\Type\Definition\IntType
     */
    public static function int()
    {
        return Type::int();
    }
    
    /**
     * @return \GraphQL\Type\Definition\StringType
     */
    public static function string()
    {
        return Type::string();
    }
    
    /**
     * @param \GraphQL\Type\Definition\Type $type
     * @return \GraphQL\Type\Definition\ListOfType
     */
    public static function listOf($type)
    {
        return Type::listOf($type);
    }
}