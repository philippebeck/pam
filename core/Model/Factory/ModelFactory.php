<?php

namespace Pam\Model\Factory;

use Pam\Model\PdoDb;

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

        $class = MODEL_PATH . ucfirst($table) . MODEL_NAME;
        
        self::$models[$table] = new $class(
            new PdoDb(
                PdoFactory::getPDO()
            )
        );

        return self::$models[$table];
    }
}
