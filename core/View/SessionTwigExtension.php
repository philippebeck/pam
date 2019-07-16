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
            new TwigFunction('userName',    array($this, 'userName')),
            new TwigFunction('userImage',   array($this, 'userImage'))
        );
    }

    /**
     * @return bool
     */
    public function isLogged()
    {
        if (array_key_exists('user', $this->session)) {

            if (!empty(filter_var_array($this->session['user']))) {

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

        return filter_var($this->session['user']['name']);
    }

    /**
     * @return mixed
     */
    public function userImage()
    {
        if ($this->isLogged() == false) {

            return null;
        }

        return filter_var($this->session['user']['image']);
    }
}

