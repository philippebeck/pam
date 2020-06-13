<?php

namespace Pam\Controller\Globals;

/**
 * Class EnvManager
 * @package Pam\Controller\Globals
 */
class EnvManager
{
    /**
     * @var mixed
     */
    private $env = null;

    /**
     * EnvManager constructor.
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

