<?php

namespace Pam\Helper;

/**
 * Class Session
 * @package Pam\Helper
 */
class Session
{
    /**
     * Session constructor
     */
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (array_key_exists('alert', $_SESSION) == false) {
            $_SESSION['alert'] = array();
        }
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $image
     * @param string $email
     */
    public static function createSession(int $id, string $name, string $image, string $email)
    {
        $_SESSION['user'] = [
            'id'    => $id,
            'name'  => $name,
            'image' => $image,
            'email' => $email
        ];
    }

    public static function destroySession()
    {
        $_SESSION['user'] = [];
        session_destroy();
    }

    /**
     * @return bool
     */
    public static function isLogged()
    {
        if (array_key_exists('user', $_SESSION)) {

            if (!empty($_SESSION['user'])) {

                return true;
            }
        }

        return false;
    }

    /**
     * @return array|null
     */
    public static function userId()
    {
        if (self::isLogged() == false) {
            return null;
        }

        return $_SESSION['user']['id'];
    }

    /**
     * @return array|null
     */
    public static function userName()
    {
        if (self::isLogged() == false) {

            return null;
        }

        return $_SESSION['user']['name'];
    }

    /**
     * @return array|null
     */
    public static function userImage()
    {
        if (self::isLogged() == false) {

            return null;
        }

        return $_SESSION['user']['image'];
    }

    /**
     * @return array|null
     */
    public static function userEmail()
    {
        if (self::isLogged() == false) {

            return null;
        }

        return $_SESSION['user']['email'];
    }

    /**
     * @param string $message
     * @param string $type
     */
    public static function createAlert(string $message, string $type = 'default')
    {
        $_SESSION['alert'] = array(
            'message' => $message,
            'type'    => $type
        );
    }

    /**
     * @return bool
     */
    public static function hasAlert()
    {
        return empty($_SESSION['alert']) == false;
    }

    public static function readType()
    {
        if (isset($_SESSION['alert'])) {

            echo $_SESSION['alert']['type'];
        }
    }

    public static function readMessage()
    {
        if (isset($_SESSION['alert'])) {

            echo $_SESSION['alert']['message'];

            unset($_SESSION['alert']);
        }
    }
}

