<?php

// ****************************** \\
// ***** PAM TWIG EXTENSION ***** \\
// ****************************** \\

namespace Pam\View;

use Pam\Model\ModelFactory;
use Pam\Helper\Session;

/** ************************\
 * Extends Twig with Pam code
 */
class Pam_Twig_Extension extends \Twig_Extension
{
    /** ***********************************************************\
     * Returns an array of functions to add to the Twig functions
     * @return Twig_Function[] => the array who contains all functions for Twig
     */
    public function getFunctions()
    {
        // Returns an array of Twig functions
        return array(
            new \Twig_Function('url',         array($this, 'url')),
            new \Twig_Function('isLogged',    array($this, 'isLogged')),
            new \Twig_Function('userId',      array($this, 'userId')),
            new \Twig_Function('userName',    array($this, 'userName')),
            new \Twig_Function('userImage',   array($this, 'userImage')),
            new \Twig_Function('userEmail',   array($this, 'userEmail')),
            new \Twig_Function('hasAlert',    array($this, 'hasAlert')),
            new \Twig_Function('readType',    array($this, 'readType')),
            new \Twig_Function('readMessage', array($this, 'readMessage'))
        );
    }

    /** **********************\
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

    /** ***************************\
     * Checks if a user is connected
     * @return bool => the user session existance
     */
    public function isLogged()
    {
        // Checks if the key user exists in the session
        if (array_key_exists('user', $_SESSION))
        {
            // Checks if the value from the key user is missing
            if (!empty($_SESSION['user']))
            {
                return true;
            }
            return false;
        }
        return false;
    }

    /** ****************************************\
     * Checks the connection then returns the id
     * @return int => the user id
     */
    public function userId()
    {
        // Checks if a user is connected
        if ($this->isLogged() == false)
        {
            return null;
        }
        // Returns the user id
        return $_SESSION['user']['id'];
    }

    /** *****************************************\
     * Checks the connection then returns the name
     * @return string => the user name
     */
    public function userName()
    {
        // Checks if a user is connected
        if ($this->isLogged() == false)
        {
            return null;
        }
        // Returns the user name
        return $_SESSION['user']['name'];
    }

    /** ******************************************\
     * Checks the connection then returns the image
     * @return string => the user image name
     */
    public function userImage()
    {
        // Checks if a user is connected
        if ($this->isLogged() == false)
        {
            return null;
        }
        // returns the user image
        return $_SESSION['user']['image'];
    }

    /** ***********************************************\
     * Checks the connection then returns the user email
     * @return string => the user email
     */
    public function userEmail()
    {
        // Checks if a user is connected
        if ($this->isLogged() == false)
        {
            return null;
        }
        // Returns the user email
        return $_SESSION['user']['email'];
    }

    /** *****************************************\
     * Checks if there is an alert in the session
     * @return bool => the alert existance
     */
    public function hasAlert()
    {
        // Returns if the alert is empty or not
        return empty($_SESSION['alert']) == false;
    }

    /** *******************\
     * Reads the alert type
     */
    public function readType()
    {
        // Checks if the alert session is set
        if (isset($_SESSION['alert']))
        {
            // Displays the alert type
            echo $_SESSION['alert']['type'];
        }
    }

    /** *********************\
     * Reads an alert message
     */
    public function readMessage()
    {
        // Checks if the alert session is set
        if (isset($_SESSION['alert']))
        {
            // Displays the alert message
            echo $_SESSION['alert']['message'];

            // Unsets the session alert
            unset($_SESSION['alert']);
        }
    }
}

