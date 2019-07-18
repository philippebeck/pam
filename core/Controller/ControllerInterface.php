<?php

namespace Pam\Controller;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Interface ControllerInterface
 * @package Pam\Controller
 */
interface ControllerInterface
{
    /**
     * @param string $page
     * @param array $params
     * @return mixed
     */
    public function url(string $page, array $params = []);

    /**
     * @param string $page
     * @param array $params
     * @return mixed
     */
    public function redirect(string $page, array $params = []);

    /**
     * @param string $view
     * @param array $params
     * @return mixed
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $view, array $params = []);
}

