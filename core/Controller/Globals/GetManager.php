<?php

namespace Pam\Controller\Globals;

/**
 * Class GetManager
 * @package Pam\Controller\Globals
 */
class GetManager
{
    /**
     * @var mixed
     */
    private $get = null;

    /**
     * GetManager constructor.
     */
    public function __construct()
    {
        $this->get = filter_input_array(INPUT_GET);
    }

    /**
     * @return mixed
     */
    public function getGetArray()
    {
        return $this->get;
    }

    /**
     * @param string $var
     * @return mixed
     */
    public function getGetVar(string $var)
    {
        return $this->get[$var];
    }
}

