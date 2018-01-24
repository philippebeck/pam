<?php

// **************************** \\
// ***** FRONT CONTROLLER ***** \\
// **************************** \\

namespace Pam\Controller;

use Pam\Helper\Session;
use Pam\View\Pam_Twig_Extension;

use App\Helper\App_Twig_Extension;


/** ****************************\
* Generic front controller class
*/
class FrontController implements FrontControllerInterface
{
  // Default constants
  const DEFAULT_PATH        = 'App\Controller\\';
  const DEFAULT_CONTROLLER  = 'HomeController';
  const DEFAULT_ACTION      = 'IndexAction';

  // Protected properties
  protected $twig           = null;
  protected $page           = null;
  protected $rubric         = null;
  protected $controller     = self::DEFAULT_CONTROLLER;
  protected $action         = self::DEFAULT_ACTION;


  /** *****************************\
   * Launchs the session, then sets the template engine
   * Parse the url, then sets the controller & the action method
   */
  public function __construct()
  {
    // Starts or continues session
    $session = new Session();

    // Sets the template engine
    $this->setTemplate();

    // Parses the request query
    $this->parseUrl();

    // Sets the controller
    $this->setController();

    // Sets the action method
    $this->setAction();
  }


  /** *************************\
  * Creates the template loader
  * Then the template engine & adds its extensions
  */
  public function setTemplate()
  {
    // Creates the loader & sets the template directory path
    $loader = new \Twig_Loader_Filesystem('../src/View');

    // Creates the template engine
    $twig = new \Twig_Environment($loader, array(
      'cache' => false,
      'debug' => true
    ));

    // Adds Twig extensions
    $twig->addExtension(new \Twig_Extension_Debug());
    $twig->addExtension(new Pam_Twig_Extension());
    $twig->addExtension(new App_Twig_Extension());

    // Attributes the template engine to the current object
    $this->twig = $twig;
  }



  /** **********************************************\
   * Checks if the request query is present, cuts it
   * And gives each part to the current controller & the current action method
   */
  public function parseUrl()
  {
    // Checks if the key access doesn't exist or if this key is not define
    if (!array_key_exists('access', $_GET) || !isset($_GET['access']))
    {
      $_GET['access'] = 'home';
    }
    // Stores the $_GET['access'] value to this page
    $this->page = $_GET['access'];

    // Cuts this page value with the exclamation point
    $access = explode('!', $this->page);

    // Attributes the first access string to this rubric
    $this->rubric = $access[0];

    // Attributes the value of this rubric to this controller
    $this->controller = $this->rubric;

    // If set, attributes the second access string to the current action method
    // if not set, attributes the string index
    $this->action = count($access) == 1 ? 'index' : $access[1];
  }


  /** **************************\
   * Sets the current controller
   * Checks if exists & sets it as default if necessary
   */
  public function setController()
  {
    // Constructs the current controller
    $this->controller = ucfirst(strtolower($this->controller)) . 'Controller';

    // Constructs the current controller with the default path
    $this->controller = self::DEFAULT_PATH . $this->controller;

    // Checks if the current controller is an existing class
    if (!class_exists($this->controller))
    {
      // Creates a warning message to inform that the asking page is not available
      Session::createAlert('La page ' . $this->page . ' est introuvable sur le serveur... Vous avez été redirigé vers la page d\'accueil...', 'warning');

      // Attributes the default path & controller to the current controller
      $this->controller = self::DEFAULT_PATH . self::DEFAULT_CONTROLLER;
    }
  }


  /** *****************************\
   * Sets the current action method
   * Checks if exists & sets it as default if necessary
   */
  public function setAction()
  {
    // Constructs the current action method
    $this->action = ucfirst(strtolower($this->action)) . 'Action';

    // Checks if the current action method exists in the current controller
    if (!method_exists($this->controller, $this->action))
    {
      // Creates a warning message to inform that the asking page is not available
      Session::createAlert('La page ' . $this->page . ' est introuvable sur le serveur... Vous avez été redirigé vers la page ' . $this->rubric . '...', 'warning');

      // Attributes the default action method to the current action method
      $this->action = self::DEFAULT_ACTION;
    }
  }


  /** ******************************\
   * Creates the controller instance
   * Then call the action method on it
   */
  public function run()
  {
    // Creates the current controller instance
    $this->controller = new $this->controller($this->twig);

    // Calls the action method on the controller
    $response = call_user_func([$this->controller, $this->action]);

    // Shows the response
    echo $response;
  }
}
