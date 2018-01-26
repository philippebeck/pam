<?php


// ********************** \\
// ***** CONTROLLER ***** \\
// ********************** \\


namespace Pam\Controller;

use Pam\Helper\Session;


/** **********************\
* Generic controller class
*/
abstract class Controller implements ControllerInterface
{
  // The Twig engine
  private $twig;


  /** **********************************\
  * Receives the Twig engine & stores it
  * @param Twig_Environment $twig => the Twig engine
  */
  public function __construct(\Twig_Environment $twig)
  {
    // Stores the Twig engine
    $this->twig = $twig;
  }



  /** ***********************\
  * Returns the url of a page
  * @param  string $page   => the name of the page
  * @param  array  $params => the url parameters
  * @return string         => the page url
  */
  public function url(string $page, array $params = [])
  {
    // Includes the page in the params array with the key 'access'
    $params['access'] = $page;

    // Returns the generate url
    return 'index.php?' . http_build_query($params);
  }



  /** *****************************************\
  * Redirects to a page with the function url()
  * @param string $page   => the name of the page
  * @param array  $params => the url parameters
  */
  public function redirect(string $page, array $params = [])
  {
    // Redirects with the url function
    header('Location: ' . $this->url($page, $params));
    exit;
  }



  /** ***************\
  * Renders the views
  * @param  string $view   => the view to render
  * @param  array  $params => (the parameters to render the view)
  * @return string         => the render of the view
  */
  public function render(string $view, array $params = [])
  {
    // Returns the rendering of the view
    return $this->twig->render($view, $params);
  }



  /** *********************************\
  * Uploads a file to a specific folder
  * And returns the file name
  * @param  string $fileDir  => the folder(s) from the file folder
  * @return string $fileName => the file name
  */
  public function upload($fileDir)
  {
    // Checks if there is an upload error
    if ($_FILES['file']['error'] > 0)
    {
      // Creates a warning message to inform the user about the error
      Session::createAlert('Erreur lors du transfert du fichier...', 'warning');
    }
    else {
      // Stores the file name
      $fileName = $_FILES['file']['name'];

      // Stores the destination path of the file
      $filePath = dirname(dirname(dirname(dirname(__DIR__)))) . "/htdocs/{$fileDir}/{$fileName}";

      // Moves the new file to his folder
      $result  = move_uploaded_file($_FILES['file']['tmp_name'], $filePath);

      // Checks if there is a result
      if ($result)
      {
        // Creates a valid message to confirm the transfer
        Session::createAlert('Transfert du nouveau fichier réussi !', 'valid');
      }
      // Returns the file name
      return $fileName;
    }
  }
}
