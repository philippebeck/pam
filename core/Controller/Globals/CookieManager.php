<?php

namespace Pam\Controller\Globals;

/**
 * Class CookieManager
 * @package Pam\Controller\Globals
 */
class CookieManager
{
    /**
     * @var mixed|null
     */
    private $cookie = null;

    /**
     * CookieManager constructor.
     */
    public function __construct()
    {
        $this->cookie = filter_input_array(INPUT_COOKIE);
    }

    /**
     * @return mixed
     */
    public function getCookieArray()
    {
        return $this->cookie;
    }

    /**
     * @param string $var
     * @return mixed
     */
    public function getCookieVar(string $var)
    {
        return $this->cookie[$var];
    }

    /**
     * @param string $name
     * @param string $value
     * @param int $expire
     * @return mixed|void
     */
    public function createCookie(string $name, string $value = "", int $expire = 0)
    {
        if ($expire === 0) {
            $expire = time() + 3600;
        }
        setcookie($name, $value, $expire, "/");
    }

    /**
     * @param string $name
     */
    public function destroyCookie(string $name)
    {
        if ($this->cookie[$name] !== null) {

            $this->createCookie($name, "", time() - 3600);
        }
    }
}

