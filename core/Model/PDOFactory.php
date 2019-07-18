<?php

namespace Pam\Model;

use PDO;

/**
 * Class PDOFactory
 * @package Pam\Model
 */
class PDOFactory
{
    /**
     * @var null
     */
    private static $pdo = null;

    /**
     * @return PDO|null
     */
    public static function getConnection()
    {
        require_once '../config/db.php';

        if (self::$pdo === null) {

            $dsn        = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
            $options    = [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];

            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            $pdo->exec('SET NAMES UTF8');

            self::$pdo = $pdo;
        }

        return self::$pdo;
    }
}

