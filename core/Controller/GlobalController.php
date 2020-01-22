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
 * Class GlobalController
 * @package Pam\Controller
 */
abstract class GlobalController
{
    /**
     * @var CookieController
     */
    protected $cookie = null;

    /**
     * @var EnvController
     */
    protected $env = null;

    /**
     * @var FilesController
     */
    protected $files = null;

    /**
     * @var GetController
     */
    protected $get = null;

    /**
     * @var PostController
     */
    protected $post = null;

    /**
     * @var RequestController
     */
    protected $request = null;

    /**
     * @var ServerController
     */
    protected $server = null;

    /**
     * @var SessionController
     */
    protected $session = null;

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
