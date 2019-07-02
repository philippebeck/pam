<?php

namespace Pam\View;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SessionTwigExtension extends AbstractExtension
{
    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction('isLogged',    array($this, 'isLogged')),
            new TwigFunction('userName',    array($this, 'userName')),
            new TwigFunction('userImage',   array($this, 'userImage'))
        );
    }

    /**
     * @return bool
     */
    public function isLogged()
    {
        if (array_key_exists('user', filter_var_array($_SESSION))) {

            if (!empty(filter_var_array($_SESSION['user']))) {

                return true;
            }
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function userName()
    {
        if ($this->isLogged() == false) {

            return null;
        }

        return filter_var($_SESSION['user']['name']);
    }

    /**
     * @return mixed
     */
    public function userImage()
    {
        if ($this->isLogged() == false) {

            return null;
        }

        return filter_var($_SESSION['user']['image']);
    }
}

