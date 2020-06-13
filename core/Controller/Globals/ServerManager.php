<?php

namespace Pam\Controller\Globals;

/**
 * Class ServerManager
 * @package Pam\Controller\Globals
 */
class ServerManager
{
    /**
     * @var mixed
     */
    private $server = null;

    /**
     * ServerManager constructor.
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

