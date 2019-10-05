<?php

namespace Pam\Model;

/**
 * Class MainModel
 * @package Pam\Model
 */
abstract class MainModel implements ModelInterface
{
    /**
     * @var DatabaseInterface
     */
    protected $database = null;

    /**
     * @var string
     */
    protected $table = null;

    /**
     * MainModel constructor
     * @param DatabaseInterface $database
     */
    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;

        $model          = explode('\\', get_class($this));
        $this->table    = ucfirst(str_replace('Model', '', array_pop($model)));
    }

    /**
     * @param string|null $value
     * @param string|null $key
     * @return array|mixed
     */
    public function listData(string $value = null, string $key = null)
    {
        if (isset($key)) {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $key . ' = ?';

            return $this->database->getAllData($query, [$value]);
        }
        $query = 'SELECT * FROM ' . $this->table;

        return $this->database->getAllData($query);
    }

    /**
     * @param array $data
     */
    public function createData(array $data)
    {
        $keys   = implode(', ', array_keys($data));
        $values = implode('", "', $data);
        $query  = 'INSERT INTO ' . $this->table . ' (' . $keys . ') VALUES ("' . $values . '")';

        $this->database->setData($query);
    }

    /**
     * @param string $value
     * @param string|null $key
     * @return array|mixed
     */
    public function readData(string $value, string $key = null)
    {
        if (isset($key)) {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $key . ' = ?';
        } else {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
        }

        return $this->database->getData($query, [$value]);
    }

    /**
     * @param string $value
     * @param array $data
     * @param string|null $key
     */
    public function updateData(string $value, array $data, string $key = null)
    {
        $set = null;

        foreach ($data as $dataKey => $dataValue) {
            $set .= $dataKey . ' = "' . $dataValue . '", ';
        }

        $set = substr_replace($set, '', -2);

        if (isset($key)) {
            $query = 'UPDATE ' . $this->table . ' SET ' . $set . ' WHERE ' . $key . ' = ?';
        } else {
            $query = 'UPDATE ' . $this->table . ' SET ' . $set . ' WHERE id = ?';
        }

        $this->database->setData($query, [$value]);
    }

    /**
     * @param string $value
     * @param string|null $key
     */
    public function deleteData(string $value, string $key = null)
    {
        if (isset($key)) {
            $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $key . ' = ?';
        } else {
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        }

        $this->database->setData($query, [$value]);
    }
}
