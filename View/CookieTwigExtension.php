<?php

namespace Pam\View;

use Pam\Controller\CookieController;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class CookieTwigExtension
 * @package Pam\View
 */
class CookieTwigExtension extends AbstractExtension
{
    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction('hasAlert',    array($this, 'hasAlert')),
            new TwigFunction('readAlert',   array($this, 'readAlert')),
            new TwigFunction('readType',    array($this, 'readType')),
            new TwigFunction('readMessage', array($this, 'readMessage'))
        );
    }

    /**
     * @return bool
     */
    public function hasAlert()
    {
        $cookie = new CookieController();

        return empty($cookie->readCookie('alert')) == false;
    }

    /**
     * @return mixed
     */
    public function readAlert()
    {
        $cookie = new CookieController();

        return $cookie->readCookie('alert');
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
        $cookie = new CookieController();
        $alert  = $this->readAlert();

        if (isset($alert)) {
            echo filter_var($alert['message']);
            $cookie->deleteCookie('alert');
        }
    }
}

