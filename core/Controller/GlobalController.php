<?php

namespace Pam\Controller;

/**
 * Class GlobalController
 * @package Pam\Controller
 */
abstract class GlobalController
{
    /**
     * @var CookieController
     */
    protected $cookie;

    /**
     * @var EnvController
     */
    protected $env;

    /**
     * @var FilesController
     */
    protected $files;

    /**
     * @var GetController
     */
    protected $get;

    /**
     * @var PostController
     */
    protected $post;

    /**
     * @var RequestController
     */
    protected $request;

    /**
     * @var ServerController
     */
    protected $server;

    /**
     * @var SessionController
     */
    protected $session;

    /**
     * GlobalController constructor
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
}
