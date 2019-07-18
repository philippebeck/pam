<?php

namespace Pam\Controller;

/**
 * Interface FrontControllerInterface
 * @package Pam\Controller
 */
interface FrontControllerInterface
{
    /**
     * @return mixed|void
     */
    public function setTemplate();

    /**
     * @return mixed|void
     */
    public function parseUrl();

    /**
     * @return mixed|void
     */
    public function setController();

    /**
     * @return mixed|void
     */
    public function setAction();

    /**
     * @return mixed|void
     */
    public function run();
}

