<?php

namespace Pam\Controller;

/**
 * Class SessionController
 * @package Pam\Controller
 */
class SessionController implements SessionControllerInterface
{
    /**
     * @var array|mixed
     */
    private $session;

    /**
     * SessionController constructor.
     */
    public function __construct()
    {
        $this->session = filter_var_array($_SESSION);
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
        if (array_key_exists('user', $this->session)) {

            if (!empty(filter_var_array($this->session['user']))) {

                return true;
            }
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function userName()
    {
        if ($this->isLogged() == false) {

            return null;
        }

        return filter_var($this->session['user']['name']);
    }

    /**
     * @return mixed
     */
    public function userImage()
    {
        if ($this->isLogged() == false) {

            return null;
        }

        return filter_var($this->session['user']['image']);
    }
}

