<?php

namespace Pam\Model;

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

        $pdo    = PdoFactory::getPDO();
        $pdoDb  = new PdoDb($pdo);
        $class  = MODEL_PATH . ucfirst($table) . MODEL_NAME;
        
        self::$models[$table] = new $class($pdoDb);

        return self::$models[$table];
    }
}
