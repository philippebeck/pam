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

    /**
     * CookieController constructor.
     */
    public function __construct()
    {
        $this->cookie = filter_input_array(INPUT_COOKIE);
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
        return filter_var($this->cookie[$name]);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function deleteCookie(string $name)
    {
        if (filter_var($this->cookie[$name]) !== null) {

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
        return empty($this->readCookie('alert')) == false;
    }

    /**
     * @return mixed|void
     */
    public function readAlert()
    {
        $alert = $this->readCookie('alert');

        if (isset($alert)) {

            echo filter_var($alert);

            $this->deleteCookie('alert');
        }
    }
}

