<?php

namespace Pam\Controller;


interface CookieControllerInterface
{
    /**
     * @param string $name
     * @param array $data
     * @param int $expire
     * @return mixed|void
     */
    public function createCookie(string $name, array $data = [], int $expire = 0);

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
     * @param string $type
     */
    public function createAlert(string $message, string $type = 'default');

    /**
     * @return bool
     */
    public function hasAlert();

    /**
     * @return mixed
     */
    public function readAlert();

    /**
     * @return mixed|void
     */
    public function readType();

    /**
     * @return mixed|void
     */
    public function readMessage();
}

