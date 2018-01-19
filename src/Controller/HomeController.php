<?php

// *************************** \\
// ***** HOME CONTROLLER ***** \\
// *************************** \\

namespace App\Controller;

use Pam\Controller\Controller;


/** *****************************\
* All control actions to the home
*/
class HomeController extends Controller
{

  /** ******************\
  * Render the main view
  * @return mixed => the rendering of the view home
  */
  public function IndexAction()
  {
    // Returns the rendering of the view home
    return $this->render('home.twig');
  }
}
