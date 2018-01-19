<?php

// ************************************** \\
// ***** FRONT CONTROLLER INTERFACE ***** \\
// ************************************** \\

namespace Pam\Controller;


/** ************************************\
 * Front controller class specifications
 */
interface FrontControllerInterface
{

  /** *************************\
  * Creates the template loader
  * Then the template engine & adds it extensions
  */
  public function setTemplate();


  /** **********************************************\
   * Checks if the request query is present, cuts it
   * And gives each part to the current controller & the current action method
   */
  public function parseUrl();


  /** **************************\
   * Sets the current controller
   * Checks if exists & sets it as default if necessary
   */
  public function setController();


  /** *****************************\
   * Sets the current action method
   * Checks if exists & sets it as default if necessary
   */
  public function setAction();


  /** ******************************\
   * Creates the controller instance
   * Then call the action method on it
   */
  public function run();
}
