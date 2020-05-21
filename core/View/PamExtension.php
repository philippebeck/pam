<?php

namespace Pam\View;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class PamExtension
 * @package Pam\View
 */
class PamExtension extends AbstractExtension
{
    /**
     * @var array|mixed
     */
    private $session = null;

    /**
     * @var mixed
     */
    private $user = null;

    /**
     * @var
     */
    private $alert = null;

    /**
     * PamExtension constructor.
     */
    public function __construct()
    {
        $this->session = filter_var_array($_SESSION);
        $this->alert = $this->session['alert'];

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
            new TwigFunction('url',             array($this, 'url')),
            new TwigFunction('getSessionArray', array($this, 'getSessionArray')),
            new TwigFunction('hasAlert',        array($this, 'hasAlert')),
            new TwigFunction('getAlertType',    array($this, 'getAlertType')),
            new TwigFunction('getAlertMessage', array($this, 'getAlertMessage')),
            new TwigFunction('isLogged',        array($this, 'isLogged')),
            new TwigFunction('getUserVar',      array($this, 'getUserVar'))
        );
    }

    /**
     * @param string $page
     * @param array $params
     * @return string
     */
    public function url(string $page, array $params = [])
    {
        $params['access'] = $page;

        return 'index.php?' . http_build_query($params);
    }

    /**
     * @return array|mixed
     */
    public function getSessionArray()
    {
        return $this->session;
    }

    /**
     * @return bool
     */
    public function hasAlert()
    {
        return empty($this->alert) === false;
    }

    /**
     * @return mixed
     */
    public function getAlertType()
    {
        if (isset($this->alert)) {

            return $this->alert['type'];
        }
    }

    public function getAlertMessage()
    {
        if (isset($this->alert)) {

            echo filter_var($this->alert['message']);

            unset($_SESSION['alert']);
        }
    }

    /**
     * @return bool
     */
    public function isLogged()
    {
        if (array_key_exists('user', $this->session)) {

            if (!empty($this->user)) {

                return true;
            }
        }
        return false;
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
