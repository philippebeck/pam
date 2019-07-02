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
    protected $cookie;

    public function __construct()
    {
        $this->cookie = new CookieController();
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction('hasAlert', array($this, 'hasAlert')),
            new TwigFunction('readAlert', array($this, 'readAlert'))
        );
    }

    /**
     * @return bool
     */
    public function hasAlert()
    {
        return empty($this->cookie->readCookie('alert')) == false;
    }

    /**
     * @return mixed
     */
    public function readAlert()
    {
        $alert = $this->cookie->readCookie('alert');

        if (isset($alert)) {
            echo filter_var($alert);
            $this->cookie->deleteCookie('alert');
        }
    }
}

