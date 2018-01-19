<?php

// ************************ \\
// ***** PDO DATABASE ***** \\
// ************************ \\

namespace Pam\Database;


/** *********************************\
 * First level access to the database
 */
class PDODatabase implements DatabaseInterface
{
  // The pdo connection
  private $pdo;


  /** **************************************\
   * Receives the pdo connection & stores it
   * @param PDO $pdo => the pdo connection to the database
   */
  public function __construct(\PDO $pdo)
  {
    // Stores the pdo connection
    $this->pdo = $pdo;
  }


  /** ***************************************\
  * Returns a unique result from the database
  * @param  string $query  => the database query
  * @param  array  $params => (the query parameters)
  * @return mixed          => the result
  */
  public function result(string $query, array $params = [])
  {
    // Prepares the query, then stores it
    $PDOStatement = $this->pdo->prepare($query);

    // Executes the prepared query
    $PDOStatement->execute($params);

    // Fetchs the result, then returns it
    return $PDOStatement->fetch();
  }


  /** ************************************\
  * Returns many results from the database
  * @param  string $query  => the database query
  * @param  array  $params => (the query parameters)
  * @return mixed          => the results
  */
  public function results(string $query, array $params = [])
  {
    // Prepares the query, then stores it
    $PDOStatement = $this->pdo->prepare($query);

    // Executes the prepared query
    $PDOStatement->execute($params);

    // Fetchs all results, then returns them
    return $PDOStatement->fetchAll();
  }


  /** ********************************\
  * Executes an action to the database
  * @param  string $query  => the database query
  * @param  array  $params => (the query parameters)
  * @return mixed          => the verity value
  */
  public function action(string $query, array $params = [])
  {
    // Prepares the query, then stores it
    $PDOStatement = $this->pdo->prepare($query);

    // Executes the query, then returns the boolean value
    return $PDOStatement->execute($params);
  }
}
