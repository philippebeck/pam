<?php

namespace Pam\Controller;

/**
 * Class FrontController
 * @package Pam\Controller
 */
class FrontController
{
    /**
     * @var string
     */
    private $controller = CTRL_DEFAULT . CTRL_NAME;

    /**
     * @var string
     */
    private $method = CTRL_METHOD_DEFAULT . CTRL_METHOD_NAME;

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
    private function parseUrl()
    {
        $access = filter_input(INPUT_GET, ACCESS_KEY);

        if (!isset($access)) {
            $access = CTRL_DEFAULT;
        }

        $access = explode("!", $access);

        $this->controller   = $access[0];
        $this->method       = count($access) == 1 ? CTRL_METHOD_DEFAULT : $access[1];
    }

    /**
     * @return mixed|void
     */
    private function setController()
    {
        $this->controller = ucfirst(strtolower($this->controller)) . CTRL_NAME;
        $this->controller = CTRL_PATH . $this->controller;

        if (!class_exists($this->controller)) {
            $this->controller = CTRL_PATH . CTRL_DEFAULT . CTRL_NAME;
        }
    }

    /**
     * @return mixed|void
     */
    private function setMethod()
    {
        $this->method = strtolower($this->method) . CTRL_METHOD_NAME;

        if (!method_exists($this->controller, $this->method)) {
            $this->method = CTRL_METHOD_DEFAULT . CTRL_METHOD_NAME;
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

