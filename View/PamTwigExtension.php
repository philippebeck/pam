<?php

namespace Pam\View;

use Pam\Helper\Session;
use Pam\Model\ModelFactory;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class PamTwigExtension
 * @package Pam\View
 */
class PamTwigExtension extends AbstractExtension
{
    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction('url',         array($this, 'url')),
            new TwigFunction('isLogged',    array($this, 'isLogged')),
            new TwigFunction('userId',      array($this, 'userId')),
            new TwigFunction('userName',    array($this, 'userName')),
            new TwigFunction('userImage',   array($this, 'userImage')),
            new TwigFunction('userEmail',   array($this, 'userEmail')),
            new TwigFunction('hasAlert',    array($this, 'hasAlert')),
            new TwigFunction('readType',    array($this, 'readType')),
            new TwigFunction('readMessage', array($this, 'readMessage'))
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
     * @return bool
     */
    public function isLogged()
    {
        if (array_key_exists('user', $_SESSION)) {

            if (!empty($_SESSION['user']))
            {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array|null
     */
    public function userId()
    {
        if ($this->isLogged() == false) {

            return null;
        }

        return $_SESSION['user']['id'];
    }

    /**
     * @return array|null
     */
    public function userName()
    {
        if ($this->isLogged() == false) {

            return null;
        }

        return $_SESSION['user']['name'];
    }

    /**
     * @return array|null
     */
    public function userImage()
    {
        if ($this->isLogged() == false) {

            return null;
        }

        return $_SESSION['user']['image'];
    }

    /**
     * @return array|null
     */
    public function userEmail()
    {
        if ($this->isLogged() == false) {

            return null;
        }

        return $_SESSION['user']['email'];
    }

    /**
     * @return array|null
     */
    public function adminEmail()
    {
        if (Session::isLogged() == false) {

            return null;
        }

        $admin = ModelFactory::get('User')->read(1);

        return $admin['email'];
    }

    /**
     * @return bool
     */
    public function hasAlert()
    {
        return empty($_SESSION['alert']) == false;
    }

    public function readType()
    {
        if (isset($_SESSION['alert'])) {

            echo $_SESSION['alert']['type'];
        }
    }

    public function readMessage()
    {
        if (isset($_SESSION['alert'])) {

            echo $_SESSION['alert']['message'];

            unset($_SESSION['alert']);
        }
    }
}

