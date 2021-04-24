<?php

namespace Pam\Model;

use PDO;

/**
 * Class PdoFactory
 * @package Pam\Model
 */
class PdoFactory
{
    /**
     * @var null
     */
    private static $pdo = null;

    /**
     * @return PDO
     */
    public static function getPDO()
    {
        if (self::$pdo === null) {

            self::$pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USER,
                DB_PASS,
                DB_OPTIONS
            );
            
            self::$pdo->exec("SET NAMES UTF8");
        }

        return self::$pdo;
    }
}
