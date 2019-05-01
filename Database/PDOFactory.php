<?php

// *********************** \\
// ***** PDO FACTORY ***** \\
// *********************** \\

namespace Pam\Database;

use \PDO;

/** *********************************************\
 * Creates the pdo connection if it doesn't exist
 */
class PDOFactory
{
    // Unique pdo instance starts at null
    static private $pdo = null;

    /** *********************************\
     * Returns the connection if it exists
     * Otherwise it creates it before returning it
     * @return PDO $pdo => The connection to the database
     */
    public static function getConnection()
    {
        // DataBase constants
        require_once dirname(dirname(dirname(dirname(__DIR__)))).'/config/bdd.php';

        // Checks if Pdo connection doesn't exist
        if (is_null(self::$pdo)) {

            // Creates the first parameters for the new pdo concerning the database
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;

            // Sets & stores the pdo options as the last parameters for the new pdo
            $options = [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];
            // Creates & stores the pdo connection
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

            // Sets the encoding characters
            $pdo->exec('SET NAMES UTF8');

            // Stores the pdo connection
            self::$pdo = $pdo;

            // Returns the connection
            return $pdo;
        } else {

            // Return the pdo connection
            return self::$pdo;
        }
    }
}

