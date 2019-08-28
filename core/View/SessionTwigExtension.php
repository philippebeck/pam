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
    private $session;

    /**
     * @var mixed
     */
    private $user;

    /**
     * SessionTwigExtension constructor.
     */
    public function __construct()
    {
        $this->session = filter_var_array($_SESSION);

        if (isset($this->session['user'])) {
            $this->user = $this->session['user'];
        }
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction('isLogged',        array($this, 'isLogged')),
            new TwigFunction('getSessionArray', array($this, 'getSessionArray')),
            new TwigFunction('getUserVar',      array($this, 'getUserVar'))
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
     * @return array|mixed
     */
    public function getSessionArray()
    {
        return $this->session;
    }

    /**
     * @param $var
     * @return mixed
     */
    public function getUserVar($var)
    {
        if ($this->isLogged() === false) {
            $this->user[$var] = null;
        }

        return $this->user[$var];
    }
}

