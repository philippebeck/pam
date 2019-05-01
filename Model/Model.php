<?php

// ***************** \\
// ***** MODEL ***** \\
// ***************** \\

namespace Pam\Model;

use Pam\Database\DatabaseInterface;

/** ************************\
 * Generic model class CRUD
 */
abstract class Model implements ModelInterface
{
    // Database access
    protected $database;

    // Table name
    protected $table;

    /** **************************************************\
     * Receive the database access & creates the table name
     * @param DatabaseInterface $database => the database access
     */
    public function __construct(DatabaseInterface $database)
    {
        // Stores access to the database
        $this->database = $database;

        // Extracts the model name from the path
        $modelName = explode('\\', get_class($this));

        // Separates the table name from the model name, then stores the name of the table
        $this->table = ucfirst(str_replace('Model', '', array_pop($modelName)));
    }

    /** *****************************************************************\
     * Lists all objects from the id with or without the order by clause
     * Or lists objects from another key with or without the order by clause
     * @param  string  $value => (the name of the where clause value)
     * @param  string  $key   => (the name of the where clause key)
     * @param  int     $order => (the order by clause with ASC(1) or DESC)
     * @return array          => the results of the query
     */
    public function list(string $value = null, string $key = null, int $order = 0)
    {
        // Checks if a key was given
        if (isset($key))
        {
            // Checks if the order needed is Ascendant
            if ($order == 1)
            {
                // Any key could be use in the where clause
                $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $key . ' = ?';
            }
            else {
                // Any key could be use in the where clause & an order by clause will be add
                $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $key . ' = ? ORDER BY ' . $key . ' DESC';
            }
            // Executes the query with parameters, then returns the results
            return $this->database->results($query, [$value]);
        }
        else {
            // Checks if the order needed is Ascendant
            if ($order == 1)
            {
                // The query would have no where clause & no order by clause
                $query = 'SELECT * FROM ' . $this->table;
            }
            else {
                // The query would have no where clause, but an order by clause
                $query = 'SELECT * FROM ' . $this->table . ' ORDER BY id DESC';
            }
            // Executes the query without parameters, then returns the results
            return $this->database->results($query);
        }
    }

    /** ******************\
     * Creates a new object
     * @param array $data => the data of the new object
     */
    public function create(array $data)
    {
        // Creates the keys string
        $keys = implode(', ', array_keys($data));

        // Creates the values string
        $values = implode('", "', $data);

        // Creates the query with the $data array keys & values
        $query = 'INSERT INTO ' . $this->table . ' (' . $keys . ') VALUES ("' . $values . '")';

        // Executes the query
        $this->database->action($query);
    }

    /** *************************\
     * Reads an object from his id
     * Or from another key
     * @param  string $value => the name of the where clause value
     * @param  string $key   => (the name of the where clause key)
     * @return array         => the results of the query
     */
    public function read(string $value, string $key = null)
    {
        // Checks if a key was given
        if (isset($key))
        {
            // Any key could be use in the where clause
            $query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $key . ' = ?';
        }
        else {
            // The id key would be use in the where clause
            $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
        }
        // Execute the select query, then returns the results
        return $this->database->result($query, [$value]);
    }

    /** ***************************\
     * Updates an object from his id
     * Or from another key
     * @param string $value => the name of the where clause value
     * @param array  $data  => the data to update the object
     * @param string $key   => (the name of the where clause key)
     */
    public function update(string $value, array $data, string $key = null)
    {
        // Initialize the set string to null
        $set = null;

        // Loops on the new data
        foreach ($data as $dataKey => $dataValue)
        {
            // Creates the set string
            $set .= $dataKey . ' = "' . $dataValue . '", ';
        }
        // Cuts the comma & the space at the end
        $set = substr_replace($set, '', -2);

        // Checks if a key was given
        if (isset($key))
        {
            // Any key could be use in the where clause
            $query = 'UPDATE ' . $this->table . ' SET ' . $set . ' WHERE ' . $key . ' = ?';
        }
        else {
            // The id key would be use in the where clause
            $query = 'UPDATE ' . $this->table . ' SET ' . $set . ' WHERE id = ?';
        }
        // Executes the query
        $this->database->action($query, [$value]);
    }

    /** ***************************\
     * Deletes an object from his id
     * Or from another key
     * @param  string $value => the name of the where clause value
     * @param  string $key   => (the name of the where clause key)
     */
    public function delete(string $value, string $key = null)
    {
        // Checks if a key was given
        if (isset($key))
        {
            // Any key could be use in the where clause
            $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $key . ' = ?';
        }
        else {
            // The id key would be use in the where clause
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        }
        // Executes the query
        $this->database->action($query, [$value]);
    }
}

