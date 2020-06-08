<?php

namespace Pam\Controller;

/**
 * Class FrontController
 * @package Pam\Controller
 */
class FrontController
{
    const DEFAULT_PATH        = "App\Controller\\";
    const DEFAULT_CONTROLLER  = "HomeController";
    const DEFAULT_METHOD      = "defaultMethod";

    /**
     * @var string
     */
    private $controller = self::DEFAULT_CONTROLLER;

    /**
     * @var string
     */
    private $method = self::DEFAULT_METHOD;

    /**
     * FrontController constructor
     */
    public function __construct()
    {
        $this->parseUrl();
        $this->setController();
        $this->setMethod();
    }

    /**
     * @return mixed|void
     */
    public function parseUrl()
    {
        $access = filter_input(INPUT_GET, "access");

        if (!isset($access)) {
            $access = "home";
        }

        $access = explode("!", $access);

        $this->controller   = $access[0];
        $this->method       = count($access) == 1 ? "default" : $access[1];
    }

    /**
     * @return mixed|void
     */
    public function setController()
    {
        $this->controller = ucfirst(strtolower($this->controller)) . "Controller";
        $this->controller = self::DEFAULT_PATH . $this->controller;

        if (!class_exists($this->controller)) {
            $this->controller = self::DEFAULT_PATH . self::DEFAULT_CONTROLLER;
        }
    }

    /**
     * @return mixed|void
     */
    public function setMethod()
    {
        $this->method = strtolower($this->method) . "Method";

        if (!method_exists($this->controller, $this->method)) {
            $this->method = self::DEFAULT_METHOD;
        }
    }

    /**
     * @return mixed|void
     */
    public function run()
    {
        $this->controller   = new $this->controller();
        $response           = call_user_func([$this->controller, $this->method]);

        echo filter_var($response);
    }
}

