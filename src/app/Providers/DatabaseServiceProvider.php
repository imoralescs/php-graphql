<?php 

namespace NamespacesName\Providers;

use PDO;

class DatabaseServiceProvider 
{
    private static $pdo;

    public static function init($config) {
        $dsn = "{$config['engine']}:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
        $username = $config['username'];
        $password = $config['password'];
        self::$pdo = new PDO($dsn, $username, $password, $config['options']);
    }

    public static function select($query) {
        $statement = self::$pdo->query($query);
        return $statement->fetchAll();
    }

    public static function selectOne($query) {
        $records = self::select($query);
        return array_shift($records);
    }

    public static function update($query) {
        $statement = self::$pdo->query($query);
        $statement->execute();
        return $statement->rowCount();
    }

    public static function insert($query) {
        $statement = self::$pdo->query($query);
        $success = $statement->execute();
        return $success ? self::$pdo->lastInsertId() : null;
    }

    public static function AffectingStatement($query) {
        $statement = self::$pdo->query($query);
        return $statement->rowCount();
    }
}