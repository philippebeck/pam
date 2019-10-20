<?php

namespace Pam\Model\Factory;

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
    public static function getPDO()
    {
        require_once '../config/db.php';

        if (self::$pdo === null) {

            self::$pdo = new PDO(DB_DSN, DB_USER, DB_PASS, DB_OPTIONS);
            self::$pdo->exec('SET NAMES UTF8');
        }

        return self::$pdo;
    }
}
