<?php

namespace Pam\Model\Factory;

use Pam\Model\PDOModel;

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
        self::$models[$table] = new $class(new PDOModel(PDOFactory::getPDO()));

        return self::$models[$table];
    }
}
