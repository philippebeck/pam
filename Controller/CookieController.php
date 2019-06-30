<?php

namespace Pam\Controller;

/**
 * Class CookieController
 * @package Pam\Controller
 */
class CookieController implements CookieControllerInterface
{
    /**
     * @param string $name
     * @param array $data
     * @param int $expire
     * @return mixed|void
     */
    public function createCookie(string $name, array $data = [], int $expire = 0)
    {
        if ($expire === 0) {
            $expire = time() + 3600;
        }
        setcookie($name, $data, $expire, '/');
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function readCookie(string $name)
    {
        return filter_input(INPUT_COOKIE, $name);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function deleteCookie(string $name)
    {
        if (filter_input(INPUT_COOKIE, $name) !== null) {
            $this->createCookie($name, [], time() - 3600);

            return true;
        }
        return false;
    }

    /**
     * @param string $message
     * @param string $type
     */
    public function createAlert(string $message, string $type = 'default')
    {
        $alert = array(
            'message' => $message,
            'type'    => $type
        );

        $this->createCookie('alert', $alert);
    }

    /**
     * @return bool
     */
    public function hasAlert()
    {
        return empty($this->readCookie('alert')) == false;
    }

    /**
     * @return mixed
     */
    public function readAlert()
    {
        return $this->readCookie('alert');
    }

    /**
     * @return mixed|void
     */
    public function readType()
    {
        $alert = $this->readAlert();

        if (isset($alert)) {
            echo filter_var($alert['type']);
        }
    }

    /**
     * @return mixed|void
     */
    public function readMessage()
    {
        $alert = $this->readAlert();

        if (isset($alert)) {
            echo filter_var($alert['message']);
            $this->deleteCookie('alert');
        }
    }
}

