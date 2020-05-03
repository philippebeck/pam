<?php

namespace Pam\Controller\Globals;

/**
 * Class SessionController
 * @package Pam\Controller
 */
class SessionController
{
    /**
     * @var mixed|null
     */
    private $session = null;

    /**
     * @var mixed|null
     */
    private $alert = null;

    /**
     * @var mixed|null
     */
    private $user = null;

    /**
     * SessionController constructor.
     */
    public function __construct()
    {
        if (array_key_exists('alert', $_SESSION) === false) {
            $_SESSION['alert'] = [];
        }

        $this->session = filter_var_array($_SESSION);
        $this->alert = $this->session['alert'];

        if (isset($this->session['user'])) {
            $this->user = $this->session['user'];
        }
    }

    /**
     * @return array|mixed
     */
    public function getSessionArray()
    {
        return $this->session;
    }

    /**
     * @param string $message
     * @param string $type
     */
    public function createAlert(string $message, string $type)
    {
        $_SESSION['alert'] = [
            'message' => $message,
            'type'    => $type
        ];
    }

    /**
     * @return bool
     */
    public function hasAlert()
    {
        return empty($this->alert) === false;
    }

    /**
     * @return mixed
     */
    public function getAlertType()
    {
        if (isset($this->alert)) {

            return $this->alert['type'];
        }
    }

    public function getAlertMessage()
    {
        if (isset($this->alert)) {

            echo filter_var($this->alert['message']);

            unset($_SESSION['alert']);
        }
    }

    /**
     * @param array $user
     */
    public function createSession(array $user)
    {
        $_SESSION['user'] = $user;
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
     * @param $var
     * @return mixed
     */
    public function getUserVar($var)
    {
        if ($this->isLogged() === false) {
            $this->user[$var] = null;
        }

        return $this->user[$var];
    }

    public function destroySession()
    {
        $_SESSION['user'] = [];
        session_destroy();
    }
}

