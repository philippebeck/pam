<?php

namespace Pam\View;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class ServiceExtension
 * @package Pam\View
 */
class ServiceExtension extends AbstractExtension
{
    /**
     * @var mixed|null
     */
    private $session = null;

    /**
     * Service Extension constructor.
     */
    public function __construct()
    {
        $this->session = filter_var_array($_SESSION) ?? [];
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction(
                "cleanString",
                array($this, "cleanString")
            ),
            new TwigFunction(
                "checkIsAdmin",
                array($this, "checkIsAdmin")
            )
        );
    }

    /**
     * @param string $string
     * @return string
     */
    public function cleanString(string $string)
    {
        $string = str_replace(
            "_", 
            " ", 
            $string
        );

        return ucwords($string);
    }

    public function checkIsAdmin()
    {
        $isAdmin = false;

        if (isset($session["user"]["admin"])) {
            if (
                $this->session["admin"] === true 
                || $this->session["admin"] === 1
            ) {
                $isAdmin = true;
            }

        } elseif (isset($session["user"]["role"])) {
            if (
                $this->session["role"] === 1 
                || $this->session["role"] === "admin"
            ) {
                $isAdmin = true;
            }
        }

        return $isAdmin;
    }
}
