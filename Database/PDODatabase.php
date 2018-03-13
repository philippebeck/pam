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
   * Make a query
   * @param  string $query  => the database query
   * @param  array  $params => (the query parameters)
   * @return  $PDOStatement => the statement
   */
  private function query(string $query, array $params = []) : PDOStatement
  {
    // Begins a transaction
    $this->pdo->beginTransaction();

    try {
      // Prepares the query, then stores it
      $PDOStatement = $this->pdo->prepare($query);

      // Executes the prepared query
      $PDOStatement->execute($params);

      // Commit
      $this->PDOStatement->commit();

      // Returns the statement
      return $PDOStatement;
    } catch (PDOException $e) {
      // Cancels the current transaction
      $this->pdo->rollback();

      // Log the error message
      error_log($e->getMessage());

      // Throw an Exception
      throw new \ErrorException('Query Error');
    }
  }


  /** ***************************************\
   * Returns a unique result from the database
   * @param  string $query  => the database query
   * @param  array  $params => (the query parameters)
   * @return mixed          => the result
   */
  public function result(string $query, array $params = []) : PDOStatement
  {
    return $this->query($query, $params)->fetch();
  }


  /** ************************************\
   * Returns many results from the database
   * @param  string $query  => the database query
   * @param  array  $params => (the query parameters)
   * @return mixed          => the results
   */
  public function results(string $query, array $params = []) : PDOStatement
  {
    return $this->query($query, $params)->fetchAll();
  }


  /** ********************************\
   * Executes an action to the database
   * @param  string $query  => the database query
   * @param  array  $params => (the query parameters)
   * @return mixed          => the verity value
   */
  public function action(string $query, array $params = []) : PDOStatement
  {
    return $this->query($query, $params);
  }
}
