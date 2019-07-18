<?php

namespace Pam\View;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class SessionTwigExtension
 * @package Pam\View
 */
class SessionTwigExtension extends AbstractExtension
{
    /**
     * @var array|mixed
     */
    private $session = [];

    /**
     * SessionTwigExtension constructor.
     */
    public function __construct()
    {
        $this->session = filter_var_array($_SESSION);
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction('isLogged',    array($this, 'isLogged')),
            new TwigFunction('userId',      array($this, 'userId')),
            new TwigFunction('userName',    array($this, 'userName')),
            new TwigFunction('userImage',   array($this, 'userImage')),
            new TwigFunction('userEmail',   array($this, 'userEmail'))
        );
    }

    /**
     * @return bool
     */
    public function isLogged()
    {
        if (array_key_exists('user', $this->session)) {

            if (!empty($this->session['user'])) {

                return true;
            }
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function userId()
    {
        if ($this->isLogged() == false) {

            return null;
        }

        return $this->session['user']['id'];
    }

    /**
     * @return mixed
     */
    public function userName()
    {
        if ($this->isLogged() == false) {

            return null;
        }

        return $this->session['user']['name'];
    }

    /**
     * @return mixed
     */
    public function userImage()
    {
        if ($this->isLogged() == false) {

            return null;
        }

        return $this->session['user']['image'];
    }

    /**
     * @return mixed
     */
    public function userEmail()
    {
        if ($this->isLogged() == false) {

            return null;
        }

        return $this->session['user']['email'];
    }
}

