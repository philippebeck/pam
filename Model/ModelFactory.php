<?php

namespace Pam\Model;

/**
 * Class ModelFactory
 * @package Pam\Model
 */
class ModelFactory
{
    /**
     * @var array
     */
    static private $models = [];

    /**
     * @param $table
     * @return mixed
     */
    static public function get($table)
    {
        if (array_key_exists($table, self::$models)) {
            return self::$models[$table];
        }

        $class  = 'App\Model\\' . ucfirst($table) . 'Model';
        $pdo    = PDOFactory::getConnection();

        $database   = new PDODatabase($pdo);
        $model      = new $class($database);

        self::$models[$table] = $model;

        return $model;
    }
}

