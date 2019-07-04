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
            new TwigFunction('hasAlert', array($this, 'hasAlert')),
            new TwigFunction('readAlert', array($this, 'readAlert'))
        );
    }

    /**
     * @return bool
     */
    public function hasAlert()
    {
        return empty(filter_input(INPUT_COOKIE, 'alert')) == false;
    }

    /**
     * @return mixed
     */
    public function readAlert()
    {
        $alert = filter_input(INPUT_COOKIE, 'alert');

        if (isset($alert)) {

            echo filter_var($alert);

            if (filter_input(INPUT_COOKIE, 'alert') !== null) {

                setcookie('alert', '', time() - 3600, '/');

                return true;
            }
            return false;
        }
    }
}

