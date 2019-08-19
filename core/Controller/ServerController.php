<?php

namespace Pam\Controller;

/**
 * Class ServerController
 * @package Pam\Controller
 */
class ServerController
{
    /**
     * @var mixed
     */
    private $server;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->server = filter_input_array(INPUT_SERVER);
    }

    /**
     * @return mixed
     */
    public function getServerArray()
    {
        return $this->server;
    }

    /**
     * @param string $var
     * @return mixed
     */
    public function getServerVar(string $var)
    {
        return $this->server[$var];
    }
}

