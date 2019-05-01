<?php

// *************************** \\
// ***** MODEL INTERFACE ***** \\
// *************************** \\

namespace Pam\Model;

/** ******************************\
 * All model classes specifications
 */
interface ModelInterface
{
    /** ***************************************************\
     * Lists all objects with or without the order by clause
     * Or lists objects from a key with or without the order by clause
     * @param  string  $value => (the name of the where clause value)
     * @param  string  $key   => (the name of the where clause key)
     * @param  int     $order => (the order by clause with ASC(1) or DESC)
     * @return array          => the results of the query
     */
    public function list(string $value = null, string $key = null, int $order = 0);

    /** ******************\
     * Creates a new object
     * @param array $data => the data of the new object
     */
    public function create(array $data);

    /** *************************\
     * Reads an object from his id
     * Or from another key
     * @param  string $value => the name of the where clause value
     * @param  string $key   => (the name of the where clause key)
     * @return array         => the results of the query
     */
    public function read(string $value, string $key = null);

    /** ***************************\
     * Updates an object from his id
     * Or from another key
     * @param string $value => the name of the where clause value
     * @param array  $data  => the data to update the object
     * @param string $key   => (the name of the where clause key)
     */
    public function update(string $value, array $data, string $key = null);

    /** ***************************\
     * Deletes an object from his id
     * Or from another key
     * @param  string $value => the name of the where clause value
     * @param  string $key   => (the name of the where clause key)
     */
    public function delete(string $value, string $key = null);
}

