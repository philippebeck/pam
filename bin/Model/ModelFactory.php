<?php

// ************************* \\
// ***** MODEL FACTORY ***** \\
// ************************* \\

namespace Pam\Model;

use Pam\Database\PDODatabase;
use Pam\Database\PDOFactory;


/** ************************************\
 * Creates the model if it doesn't exist
 */
class ModelFactory
{
  // The empty model
  static private $models = [];


/** ****************************\
* Returns the model if it exists
* Otherwise it creates the connection & the model before returning it
* @param  string $table => the table name of the active model
* @return Model  $model => the object of the model concerned
*/
  static public function get($table)
  {
    // Checks if object model exist
    if (array_key_exists($table, self::$models))
    {
      // Returns the existing model object
      return self::$models[$table];
    }
    // Assembling the class name with the appropriate namespace
    $class = 'App\Model\\' . ucfirst($table) . 'Model';

    // Creates the pdo connection
    $pdo = PDOFactory::getConnection();

    // Creates the database object
    $database = new PDODatabase($pdo);

    // Creates the model object
    $model = new $class($database);

    // Saves the model object
    self::$models[$table] = $model;

    // Returns the model object
    return $model;
  }
}
