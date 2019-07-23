<?php

namespace Pam\Controller;

/**
 * Class SessionController
 * @package Pam\Controller
 */
class SessionController
{
    /**
     * @var array|mixed
     */
    private $session;

    /**
     * @var mixed
     */
    private $user;

    /**
     * SessionController constructor.
     */
    public function __construct()
    {
        $this->session = filter_var_array($_SESSION);

        if (isset($this->session['user'])) {
            $this->user = $this->session['user'];
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
        if (array_key_exists('user', $this->session)) {

            if (!empty($this->user)) {

                return true;
            }
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function userId()
    {
        if ($this->isLogged() == false) {

            return null;
        }

        return $this->user['id'];
    }

    /**
     * @return mixed
     */
    public function userName()
    {
        if ($this->isLogged() == false) {

            return null;
        }

        return $this->user['name'];
    }

    /**
     * @return mixed
     */
    public function userImage()
    {
        if ($this->isLogged() == false) {

            return null;
        }

        return $this->user['image'];
    }

    /**
     * @return mixed
     */
    public function userEmail()
    {
        if ($this->isLogged() == false) {

            return null;
        }

        return $this->user['email'];
    }
}

