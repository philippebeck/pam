<?php

namespace Pam\Model;

use Pam\Database\DatabaseInterface;

/**
 * Class Model
 * @package Pam\Model
 */
abstract class Model implements ModelInterface
{
    /**
     * @var DatabaseInterface
     */
    protected $database;

    /**
     * @var string
     */
    protected $table;

    /**
     * Model constructor
     * @param DatabaseInterface $database
     */
    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;
        $modelName      = explode('\\', get_class($this));
        $this->table    = ucfirst(str_replace('Model', '', array_pop($modelName)));
    }

    /**
     * @param string|null $value
     * @param string|null $key
     * @param int $order
     * @return array|mixed
     */
    public function list(string $value = null, string $key = null, int $order = 0)
    {
        if (isset($key)) {

            if ($order == 0) {
                $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $key . ' = ?';
            } else {
                $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $key . ' = ? ORDER BY ' . $key . ' DESC';
            }

            return $this->database->results($query, [$value]);
        }

        if ($order == 0) {
            $query = 'SELECT * FROM ' . $this->table;
        } else {
            $query = 'SELECT * FROM ' . $this->table . ' ORDER BY id DESC';
        }

        return $this->database->results($query);
    }

    /**
     * @param array $data
     */
    public function create(array $data)
    {
        $keys   = implode(', ', array_keys($data));
        $values = implode('", "', $data);
        $query  = 'INSERT INTO ' . $this->table . ' (' . $keys . ') VALUES ("' . $values . '")';

        $this->database->action($query);
    }

    /**
     * @param string $value
     * @param string|null $key
     * @return array|mixed
     */
    public function read(string $value, string $key = null)
    {
        if (isset($key)) {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $key . ' = ?';
        } else {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
        }

        return $this->database->result($query, [$value]);
    }

    /**
     * @param string $value
     * @param array $data
     * @param string|null $key
     */
    public function update(string $value, array $data, string $key = null)
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

        $this->database->action($query, [$value]);
    }

    /**
     * @param string $value
     * @param string|null $key
     */
    public function delete(string $value, string $key = null)
    {
        if (isset($key)) {
            $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $key . ' = ?';
        } else {
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        }

        $this->database->action($query, [$value]);
    }
}

