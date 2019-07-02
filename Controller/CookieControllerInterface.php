<?php

namespace Pam\Controller;


interface CookieControllerInterface
{
    /**
     * @param string $name
     * @param string $value
     * @param int $expire
     * @return mixed|void
     */
    public function createCookie(string $name, string $value = '', int $expire = 0);

    /**
     * @param string $name
     * @return mixed
     */
    public function readCookie(string $name);

    /**
     * @param string $name
     * @return bool
     */
    public function deleteCookie(string $name);

    /**
     * @param string $message
     */
    public function createAlert(string $message);

    /**
     * @return bool
     */
    public function hasAlert();


    /**
     * @return mixed|void
     */
    public function readAlert();
}

