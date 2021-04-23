<?php

namespace Pam\View;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class MainExtension
 * @package Pam\View
 */
class MainExtension extends AbstractExtension
{
    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction(
                "url", 
                array($this, "url")
            ),
            new TwigFunction(
                "redirect", 
                array($this, "redirect")
            )
        );
    }

    /**
     * @param string $access
     * @param array $params
     * @return string
     */
    public function url(string $access, array $params = [])
    {
        $params["access"] = $access;

        return "index.php?" . http_build_query($params);
    }

    /**
     * @param string $access
     * @param array $params
     */
    public function redirect(string $access, array $params = [])
    {
        header("Location: " . $this->url($access, $params));

        exit;
    }
}
