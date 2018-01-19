<?php

// ****************************** \\
// ***** DATABASE INTERFACE ***** \\
// ****************************** \\

namespace Pam\Database;


/** *********************************\
* All database classes specifications
*/
interface DatabaseInterface
{

  /** *********************\
  * Returns a unique result
  * @param  string $query  => the database query
  * @param  array  $params => (the query parameters)
  * @return mixed          => the result
  */
  public function result(string $query, array $params = []);


  /** *****************\
  * Returns all results
  * @param  string $query  => the database query
  * @param  array  $params => (the query parameters)
  * @return mixed          => the results
  */
  public function results(string $query, array $params = []);


  /** ****************\
  * Executes an action
  * @param  string $query  => the database query
  * @param  array  $params => (the query parameters)
  * @return mixed          => the boolean value
  */
  public function action(string $query, array $params = []);
}
