<?php

namespace Pam\View;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class CookieTwigExtension
 * @package Pam\View
 */
class CookieTwigExtension extends AbstractExtension
{
    /**
     * @var mixed|null
     */
    private $alert = null;

    /**
     * CookieTwigExtension constructor.
     */
    public function __construct()
    {
        $this->alert = filter_input(INPUT_COOKIE, 'alert');
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
        return empty($this->alert) == false;
    }

    /**
     * @return mixed
     */
    public function readAlert()
    {
        if (isset($this->alert)) {

            echo filter_var($this->alert);

            if ($this->alert !== null) {

                setcookie('alert', '', time() - 3600, '/');
            }
        }
    }
}

