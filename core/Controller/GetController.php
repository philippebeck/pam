<?php

namespace Pam\Controller;

/**
 * Class GetController
 * @package Pam\Controller
 */
class GetController
{
    /**
     * @var mixed
     */
    private $get;

    /**
     * GetController constructor.
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

