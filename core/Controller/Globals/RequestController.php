<?php

namespace Pam\Controller\Globals;

/**
 * Class RequestController
 * @package Pam\Controller
 */
class RequestController
{
    /**
     * @var mixed
     */
    private $request;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->request = filter_var_array($_REQUEST);
    }

    /**
     * @return mixed
     */
    public function getRequestArray()
    {
        return $this->request;
    }

    /**
     * @param string $var
     * @return mixed
     */
    public function getRequestVar(string $var)
    {
        return $this->request[$var];
    }
}
