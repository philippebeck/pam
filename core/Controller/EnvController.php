<?php

namespace Pam\Controller;

/**
 * Class EnvController
 * @package Pam\Controller
 */
class EnvController
{
    /**
     * @var mixed
     */
    private $env;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->env = filter_input_array(INPUT_ENV);
    }

    /**
     * @return mixed
     */
    public function getEnvArray()
    {
        return $this->env;
    }

    /**
     * @param string $var
     * @return mixed
     */
    public function getEnvVar(string $var)
    {
        return $this->env[$var];
    }
}

