<?php

// ******************* \\
// ***** SESSION ***** \\
// ******************* \\

namespace Pam\Helper;

/** ******************\
 * Helper Session class
 */
class Session
{
    /**
     * Checks then creates the session & the messages array
     */
    public function __construct()
    {
        // Checks if a session doesn't exist
        if (session_status() == PHP_SESSION_NONE)
        {
            // We start it
            session_start();
        }
        // Checks if the session has an array for messages
        if (array_key_exists('alert', $_SESSION) == false)
        {
            // We create it
            $_SESSION['alert'] = array();
        }
    }

    /** **********************\
     * Creates the user session
     * @param int    $id     => the user id
     * @param string $name   => the user name
     * @param string $image  => the user image name
     * @param string $email  => the user email
     */
    public static function createSession(int $id, string $name, string $image, string $email)
    {
        // Creates the user session with the user datas
        $_SESSION['user'] =
            [
                'id'    => $id,
                'name'  => $name,
                'image' => $image,
                'email' => $email
            ];
    }

    /** ***********************\
     * Destroys the user session
     */
    public static function destroySession()
    {
        // Destroys the user session datas
        $_SESSION['user'] = [];

        // Destroys the session
        session_destroy();
    }

    /** ***************************\
     * Checks if a user is connected
     * @return bool => the user session existance
     */
    public static function isLogged()
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
    public static function userId()
    {
        // Checks if a user is connected
        if (self::isLogged() == false)
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
    public static function userName()
    {
        // Checks if a user is connected
        if (self::isLogged() == false)
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
    public static function userImage()
    {
        // Checks if a user is connected
        if (self::isLogged() == false)
        {
            return null;
        }
        // returns the user image
        return $_SESSION['user']['image'];
    }

    /** ******************************************\
     * Checks the connection then returns the email
     * @return string => the user email
     */
    public static function userEmail()
    {
        // Checks if a user is connected
        if (self::isLogged() == false)
        {
            return null;
        }
        // Returns the user email
        return $_SESSION['user']['email'];
    }

    /** *********************************************\
     * Creates the alert session with the alert datas
     * @param string $message => the alert message
     * @param string $type    => the alert type
     */
    public static function createAlert(string $message, string $type = 'default')
    {
        // creates an array who contains the alert datas
        $_SESSION['alert'] = array(
            'message' => $message,
            'type'    => $type
        );
    }

    /** *****************************************\
     * Checks if there is an alert in the session
     * @return bool => the alert existance
     */
    public static function hasAlert()
    {
        // Returns if the alert is empty or not
        return empty($_SESSION['alert']) == false;
    }

    /** *******************\
     * Reads the alert type
     */
    public static function readType()
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
    public static function readMessage()
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

