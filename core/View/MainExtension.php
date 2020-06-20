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
            new TwigFunction("url", array($this, "url")),
            new TwigFunction("redirect", array($this, "redirect"))
        );
    }

    /**
     * @param string $page
     * @param array $params
     * @return string
     */
    public function url(string $page, array $params = [])
    {
        $params["access"] = $page;

        return "index.php?" . http_build_query($params);
    }

    /**
     * @param string $page
     * @param array $params
     */
    public function redirect(string $page, array $params = [])
    {
        header("Location: " . $this->url($page, $params));

        exit;
    }
}
