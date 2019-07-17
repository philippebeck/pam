<?php

namespace Pam\Controller;

/**
 * Interface GetControllerInterface
 * @package Pam\Controller
 */
interface GetControllerInterface
{
    /**
     * @return mixed
     */
    public function getGetArray();

    /**
     * @param string $var
     * @return mixed
     */
    public function getGetVar(string $var);
}

