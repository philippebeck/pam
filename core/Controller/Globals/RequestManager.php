<?php

namespace Pam\Controller\Globals;

/**
 * Class RequestManager
 * @package Pam\Controller\Globals
 */
class RequestManager
{
    /**
     * @var mixed
     */
    private $request = null;

    /**
     * RequestManager constructor.
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
