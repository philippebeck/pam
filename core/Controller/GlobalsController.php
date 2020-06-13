<?php

namespace Pam\Controller;

use Pam\Controller\Globals\CookieManager;
use Pam\Controller\Globals\EnvManager;
use Pam\Controller\Globals\FilesManager;
use Pam\Controller\Globals\GetManager;
use Pam\Controller\Globals\PostManager;
use Pam\Controller\Globals\RequestManager;
use Pam\Controller\Globals\ServerManager;
use Pam\Controller\Globals\SessionManager;

/**
 * Class GlobalsController
 * @package Pam\Controller
 */
abstract class GlobalsController
{
    /**
     * @var CookieManager
     */
    private $cookie = null;

    /**
     * @var EnvManager
     */
    private $env = null;

    /**
     * @var FilesManager
     */
    private $files = null;

    /**
     * @var GetManager
     */
    private $get = null;

    /**
     * @var PostManager
     */
    private $post = null;

    /**
     * @var RequestManager
     */
    private $request = null;

    /**
     * @var ServerManager
     */
    private $server = null;

    /**
     * @var SessionManager
     */
    private $session = null;

    /**
     * GlobalsController constructor
     */
    public function __construct()
    {
        $this->cookie   = new CookieManager();
        $this->env      = new EnvManager();
        $this->files    = new FilesManager();
        $this->get      = new GetManager();
        $this->post     = new PostManager();
        $this->request  = new RequestManager();
        $this->server   = new ServerManager();
        $this->session  = new SessionManager();
    }

    /**
     * @return CookieManager
     */
    public function getCookie(): CookieManager
    {
        return $this->cookie;
    }

    /**
     * @return EnvManager
     */
    public function getEnv(): EnvManager
    {
        return $this->env;
    }

    /**
     * @return FilesManager
     */
    public function getFiles(): FilesManager
    {
        return $this->files;
    }

    /**
     * @return GetManager
     */
    public function getGet(): GetManager
    {
        return $this->get;
    }

    /**
     * @return PostManager
     */
    public function getPost(): PostManager
    {
        return $this->post;
    }

    /**
     * @return RequestManager
     */
    public function getRequest(): RequestManager
    {
        return $this->request;
    }

    /**
     * @return ServerManager
     */
    public function getServer(): ServerManager
    {
        return $this->server;
    }

    /**
     * @return SessionManager
     */
    public function getSession(): SessionManager
    {
        return $this->session;
    }
}
