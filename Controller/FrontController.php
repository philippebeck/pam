<?php

namespace Pam\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Pam\View\PamTwigExtension;

/**
 * Class FrontController
 * @package Pam\Controller
 */
class FrontController implements FrontControllerInterface
{
    const DEFAULT_PATH        = 'App\Controller\\';
    const DEFAULT_CONTROLLER  = 'HomeController';
    const DEFAULT_ACTION      = 'IndexAction';

    /**
     * @var null
     */
    protected $twig = null;

    /**
     * @var string
     */
    protected $controller = self::DEFAULT_CONTROLLER;

    /**
     * @var string
     */
    protected $action = self::DEFAULT_ACTION;

    /**
     * FrontController constructor
     */
    public function __construct()
    {
        $this->setTemplate();
        $this->parseUrl();
        $this->setController();
        $this->setAction();
    }

    /**
     * @return mixed|void
     */
    public function setTemplate()
    {
        $loader = new FilesystemLoader('../src/View');
        $twig   = new Environment($loader, array(
            'cache' => false,
            'debug' => true
        ));

        $twig->addExtension(new DebugExtension());
        $twig->addExtension(new PamTwigExtension());

        $this->twig = $twig;
    }

    /**
     * @return mixed|void
     */
    public function parseUrl()
    {
        $access = filter_input(INPUT_GET, 'access');

        if (!isset($access)) {
            $access = 'home';
        }

        $access = explode('!', $access);

        $this->controller   = $access[0];
        $this->action       = count($access) == 1 ? 'index' : $access[1];
    }

    /**
     * @return mixed|void
     */
    public function setController()
    {
        $this->controller = ucfirst(strtolower($this->controller)) . 'Controller';
        $this->controller = self::DEFAULT_PATH . $this->controller;

        if (!class_exists($this->controller)) {
            $this->controller = self::DEFAULT_PATH . self::DEFAULT_CONTROLLER;
        }
    }

    /**
     * @return mixed|void
     */
    public function setAction()
    {
        $this->action = strtolower($this->action) . 'Action';

        if (!method_exists($this->controller, $this->action)) {
            $this->action = self::DEFAULT_ACTION;
        }
    }

    /**
     * @return mixed|void
     */
    public function run()
    {
        $this->controller   = new $this->controller($this->twig);
        $response           = call_user_func([$this->controller, $this->action]);

        echo $response;
    }
}

