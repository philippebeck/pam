<?php

namespace Pam\Controller;

use Pam\View\GlobalsExtension;
use Pam\View\MainExtension;
use Pam\View\ServiceExtension;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

/**
 * Class MainController
 * @package Pam\Controller
 */
abstract class MainController extends ServiceController
{
    /**
     * @var Environment|null
     */
    protected $twig = null;

    /**
     * MainController constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->twig = new Environment(new FilesystemLoader(VIEW_PATH), array("cache" => VIEW_CACHE));

        $this->twig->addExtension(new MainExtension());
        $this->twig->addExtension(new GlobalsExtension());
        $this->twig->addExtension(new ServiceExtension());
    }

    /**
     * @param string $access
     * @param array $params
     * @return string
     */
    protected function url(string $access, array $params = [])
    {
        $params[ACCESS_KEY] = $access;

        return "index.php?" . http_build_query($params);
    }

    /**
     * @param string $access
     * @param array $params
     */
    protected function redirect(string $access, array $params = [])
    {
        header("Location: " . $this->url($access, $params));

        exit;
    }

    /**
     * @param string $view
     * @param array $params
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    protected function render(string $view, array $params = [])
    {
        return $this->twig->render($view, $params);
    }
}
