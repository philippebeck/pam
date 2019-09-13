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
    public static function getModel(string $table)
    {
        if (array_key_exists($table, self::$models)) {
            return self::$models[$table];
        }

        $class = 'App\Model\\' . ucfirst($table) . 'Model';
        self::$models[$table] = new $class(new PDODatabase(PDOFactory::getPDO()));

        return self::$models[$table];
    }
}

