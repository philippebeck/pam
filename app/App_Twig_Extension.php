<?php

// ****************************** \\
// ***** APP TWIG EXTENSION ***** \\
// ****************************** \\

namespace App\Helper;

use Pam\Model\ModelFactory;
use Pam\Helper\Session;


/** ********************************\
* Extends Twig with Application code
*/
class App_Twig_Extension extends \Twig_Extension
{

  /** ***********************************************************\
  * Returns an array of functions to add to the Twig functions
  * @return Twig_Function[] => the array who contains all functions for Twig
  */
  public function getFunctions()
  {
    // Returns an array of Twig functions
    return array();
  }
}
