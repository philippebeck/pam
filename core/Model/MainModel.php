<?php

namespace Pam\Model;

/**
 * Class MainModel
 * @package Pam\Model
 */
abstract class MainModel
{
    /**
     * @var PdoDb
     */
    protected $database = null;

    /**
     * @var string
     */
    protected $table = "";

    /**
     * MainModel constructor
     * @param PdoDb $database
     */
    public function __construct(PdoDb $database)
    {
        $this->database = $database;

        $model          = explode("\\", get_class($this));
        $this->table    = ucfirst(str_replace(MODEL_NAME, "", array_pop($model)));
    }

    // ******************** LIST ******************** \\

    /**
     * @param string|null $value
     * @param string|null $key
     * @return array|mixed
     */
    public function listData(string $value = null, string $key = null)
    {
        if (isset($key)) {

            return $this->database->getAllData(
                "SELECT * FROM " . $this->table . " WHERE " . $key . " = ?", 
                [$value]
            );
        }

        return $this->database->getAllData(
            "SELECT * FROM " . $this->table
        );
    }

    // ******************** CREATE ******************** \\

    /**
     * @param array $data
     */
    public function createData(array $data)
    {
        $keys   = implode(", ", array_keys($data));
        $values = implode("', '", $data);
        $query  = "INSERT INTO " . $this->table . " (" . $keys . ") VALUES ('" . $values . "')";

        $this->database->setData($query);
    }

    // ******************** READ ******************** \\

    /**
     * @param string $value
     * @param string|null $key
     * @return array|mixed
     */
    public function readData(string $value, string $key = null)
    {
        if (isset($key)) {

            return $this->database->getData(
                "SELECT * FROM " . $this->table . " WHERE " . $key . " = ?", 
                [$value]
            );
        }

        return $this->database->getData(
            "SELECT * FROM " . $this->table . " WHERE id = ?", 
            [$value]
        );
    }

    // ******************** UPDATE ******************** \\

    /**
     * @param string $value
     * @param array $data
     * @param string|null $key
     */
    public function updateData(string $value, array $data, string $key = null)
    {
        $set = null;

        foreach ($data as $dataKey => $dataValue) {
            $set .= $dataKey . " = '" . $dataValue . "', ";
        }

        $set = substr_replace($set, "", -2);

        if (isset($key)) {
            $query = "UPDATE " . $this->table . " SET " . $set . " WHERE " . $key . " = ?";

        } else {
            $query = "UPDATE " . $this->table . " SET " . $set . " WHERE id = ?";
        }

        $this->database->setData($query, [$value]);
    }

    // ******************** DELETE ******************** \\

    /**
     * @param string $value
     * @param string|null $key
     */
    public function deleteData(string $value, string $key = null)
    {
        if (isset($key)) {
            $query = "DELETE FROM " . $this->table . " WHERE " . $key . " = ?";

        } else {
            $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        }

        $this->database->setData($query, [$value]);
    }
}
