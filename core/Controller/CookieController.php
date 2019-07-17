<?php

namespace Pam\Controller;

/**
 * Class CookieController
 * @package Pam\Controller
 */
class CookieController implements CookieControllerInterface
{
    /**
     * @var mixed
     */
    private $cookie;

    private $alert;

    /**
     * CookieController constructor.
     */
    public function __construct()
    {
        $this->cookie = filter_input_array(INPUT_COOKIE);
        $this->alert  = $this->cookie['alert'];
    }

    /**
     * @param string $name
     * @param string $value
     * @param int $expire
     * @return mixed|void
     */
    public function createCookie(string $name, string $value = '', int $expire = 0)
    {
        if ($expire === 0) {
            $expire = time() + 3600;
        }
        setcookie($name, $value, $expire, '/');
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function readCookie(string $name)
    {
        return $this->cookie[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function deleteCookie(string $name)
    {
        if ($this->cookie[$name] !== null) {

            $this->createCookie($name, '', time() - 3600);
        }
    }

    /**
     * @param string $message
     */
    public function createAlert(string $message)
    {
        $this->createCookie('alert', $message);
    }

    /**
     * @return bool
     */
    public function hasAlert()
    {
        return empty($this->alert) == false;
    }

    /**
     * @return mixed|void
     */
    public function readAlert()
    {
        if (isset($this->alert)) {

            echo filter_var($this->alert);

            $this->deleteCookie('alert');
        }
    }
}

