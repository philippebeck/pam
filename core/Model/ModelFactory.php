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
    private static $models = [];

    /**
     * @param $table
     * @return mixed
     */
    public static function getModel($table)
    {
        if (array_key_exists($table, self::$models)) {
            return self::$models[$table];
        }

        $class  = 'App\Model\\' . ucfirst($table) . 'Model';
        $pdo    = PDOFactory::getPDO();

        $database   = new PDODatabase($pdo);
        $model      = new $class($database);

        self::$models[$table] = $model;

        return $model;
    }
}

