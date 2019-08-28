<?php

namespace Pam\View;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class CookieTwigExtension
 * @package Pam\View
 */
class CookieTwigExtension extends AbstractExtension
{
    /**
     * @var mixed
     */
    private $cookie;

    /**
     * @var
     */
    private $alert;

    /**
     * CookieTwigExtension constructor.
     */
    public function __construct()
    {
        $this->cookie = filter_input_array(INPUT_COOKIE);

        if (isset($this->cookie['alert'])) {
            $this->alert  = $this->cookie['alert'];
        }
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction('getCookieArray',  array($this, 'getCookieArray')),
            new TwigFunction('hasAlert',        array($this, 'hasAlert')),
            new TwigFunction('readAlert',       array($this, 'readAlert'))
        );
    }

    /**
     * @return mixed
     */
    public function getCookieArray()
    {
        return $this->cookie;
    }

    /**
     * @return bool
     */
    public function hasAlert()
    {
        return empty($this->alert) == false;
    }

    /**
     * @return mixed
     */
    public function readAlert()
    {
        if (isset($this->alert)) {
            echo filter_var($this->alert, FILTER_SANITIZE_SPECIAL_CHARS);

            if ($this->alert !== null) {
                setcookie('alert', '', time() - 3600, '/');
            }
        }
    }
}

