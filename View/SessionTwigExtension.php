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
            new TwigFunction('readUser',    array($this, 'readUser')),
            new TwigFunction('userName',    array($this, 'userName')),
            new TwigFunction('userImage',   array($this, 'userImage'))
        );
    }

    /**
     * @return bool
     */
    public function isLogged()
    {
        if (array_key_exists('user', filter_input_array(INPUT_SESSION))) {

            if (!empty(filter_input(INPUT_SESSION, 'user'))) {

                return true;
            }
        }
        return false;
    }

    /**
     * @return mixed|null
     */
    public function readUser()
    {
        if ($this->isLogged() == false) {

            return null;
        }
    }

    /**
     * @return mixed
     */
    public function userName()
    {
        $this->readUser();

        return filter_input(INPUT_SESSION, ['user']['name']);
    }

    /**
     * @return mixed
     */
    public function userImage()
    {
        $this->readUser();

        return filter_input(INPUT_SESSION, ['user']['image']);
    }
}

