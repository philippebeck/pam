<?php

namespace Pam\Controller;

/**
 * Class SessionController
 * @package Pam\Controller
 */
class SessionController implements SessionControllerInterface
{
    /**
     * SessionController constructor.
     */
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $image
     * @param string $email
     */
    public function createSession(int $id, string $name, string $image, string $email)
    {
        $_SESSION['user'] = [
            'id'    => $id,
            'name'  => $name,
            'image' => $image,
            'email' => $email
        ];
    }

    /**
     * @return void
     */
    public function destroySession()
    {
        $_SESSION['user'] = [];
        session_destroy();
    }

    /**
     * @return bool
     */
    public function isLogged()
    {
        if (array_key_exists('user', filter_input_array(INPUT_SESSION))) {

            if (!empty(filter_input(INPUT_SESSION, 'user'))) {

                return true;
            }
        }
        return false;
    }

    /**
     * @return null
     */
    public function readUser()
    {
        if ($this->isLogged() == false) {

            return null;
        }
    }

    /**
     * @return mixed
     */
    public function userName()
    {
        $this->readUser();

        return filter_input(INPUT_SESSION, ['user']['name']);
    }

    /**
     * @return mixed
     */
    public function userImage()
    {
        $this->readUser();

        return filter_input(INPUT_SESSION, ['user']['image']);
    }
}

