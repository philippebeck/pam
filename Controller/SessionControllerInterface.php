<?php

namespace Pam\Controller;

/**
 * Interface SessionControllerInterface
 * @package Pam\Controller
 */
interface SessionControllerInterface
{
    /**
     * @param int $id
     * @param string $name
     * @param string $image
     * @param string $email
     */
    public function createSession(int $id, string $name, string $image, string $email);

    /**
     * @return void
     */
    public function destroySession();

    /**
     * @return bool
     */
    public function isLogged();


    /**
     * @return null
     */
    public function readUser();

    /**
     * @return mixed
     */
    public function userName();

    /**
     * @return mixed
     */
    public function userImage();
}

