<?php

namespace Pam\Controller;

/**
 * Interface PostControllerInterface
 * @package Pam\Controller
 */
interface PostControllerInterface
{
    /**
     * @return mixed
     */
    public function getPostArray();

    /**
     * @param string $var
     * @return mixed
     */
    public function getPostVar(string $var);
}

