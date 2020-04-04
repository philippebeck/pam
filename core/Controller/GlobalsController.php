<?php

namespace Pam\Controller;

use Pam\Controller\Globals\CookieController;
use Pam\Controller\Globals\EnvController;
use Pam\Controller\Globals\FilesController;
use Pam\Controller\Globals\GetController;
use Pam\Controller\Globals\PostController;
use Pam\Controller\Globals\RequestController;
use Pam\Controller\Globals\ServerController;
use Pam\Controller\Globals\SessionController;

/**
 * Class GlobalsController
 * @package Pam\Controller
 */
class GlobalsController
{
    /**
     * @var CookieController
     */
    private $cookie = null;

    /**
     * @var EnvController
     */
    private $env = null;

    /**
     * @var FilesController
     */
    private $files = null;

    /**
     * @var GetController
     */
    private $get = null;

    /**
     * @var PostController
     */
    private $post = null;

    /**
     * @var RequestController
     */
    private $request = null;

    /**
     * @var ServerController
     */
    private $server = null;

    /**
     * @var SessionController
     */
    private $session = null;

    /**
     * GlobalsController constructor
     */
    public function __construct()
    {
        $this->cookie   = new CookieController();
        $this->env      = new EnvController();
        $this->files    = new FilesController();
        $this->get      = new GetController();
        $this->post     = new PostController();
        $this->request  = new RequestController();
        $this->server   = new ServerController();
        $this->session  = new SessionController();
    }

    /**
     * @return CookieController
     */
    public function getCookie(): CookieController
    {
        return $this->cookie;
    }

    /**
     * @return EnvController
     */
    public function getEnv(): EnvController
    {
        return $this->env;
    }

    /**
     * @return FilesController
     */
    public function getFiles(): FilesController
    {
        return $this->files;
    }

    /**
     * @return GetController
     */
    public function getGet(): GetController
    {
        return $this->get;
    }

    /**
     * @return PostController
     */
    public function getPost(): PostController
    {
        return $this->post;
    }

    /**
     * @return RequestController
     */
    public function getRequest(): RequestController
    {
        return $this->request;
    }

    /**
     * @return ServerController
     */
    public function getServer(): ServerController
    {
        return $this->server;
    }

    /**
     * @return SessionController
     */
    public function getSession(): SessionController
    {
        return $this->session;
    }
}
