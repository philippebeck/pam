<?php

// *********************** \\
// ***** PDO FACTORY ***** \\
// *********************** \\

namespace Pam\Database;

use \PDO;

// DataBase constants
require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/app/config.php';

/** *********************************************\
 * Creates the pdo connection if it doesn't exist
 */
class PDOFactory
{
  // Unique pdo instance starts at null
  static private $pdo = null;

  // Credentials for PDO instance
  private const CREDENTIALS = CREDENTIALS;

  // dsn for PDO instance
  private const DSN = 'mysql:host=' . CREDENTIALS['host'] . ';dbname=' . CREDENTIALS['dbname'];

  // Options for PDO instance
  private const OPTIONS = OPTIONS;


  /** *********************************\
   * Returns the connection if it exists
   * Otherwise it creates it before returning it
   * @return PDO $pdo => The connection to the database
   */
  public static function getConnection() : PDOStatement
  {
    // Checks if PDO connection doesn't exist
    if (is_null(self::$pdo)) {
      try {
        // Creates & stores the PDO instance
        $pdo = new PDO($this->DSN, $this->CREDENTIALS['user'], $this->CREDENTIALS['password'], $this->OPTIONS);

        // Stores the PDO instance
        self::$pdo = $pdo;

        // Returns the PDO instance
        return $pdo;
      } catch (PDOException $e) {
        // Log the error message
        error_log($e->getMessage());

        // Throw an Exception
        throw new \ErrorException('Failed to instance PDO');
      }
    }
  }
}
