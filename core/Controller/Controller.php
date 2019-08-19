<?php

namespace Pam\Controller;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Controller
 * @package Pam\Controller
 */
abstract class Controller implements ControllerInterface
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var CookieController
     */
    protected $cookie;

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
     * @var SessionController
     */
    protected $session;

    /**
     * Controller constructor
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;

        $this->cookie   = new CookieController();
        $this->files    = new FilesController();
        $this->get      = new GetController();
        $this->post     = new PostController();
        $this->session  = new SessionController();
    }

    /**
     * @param string $page
     * @param array $params
     * @return string
     */
    public function url(string $page, array $params = [])
    {
        $params['access'] = $page;

        return 'index.php?' . http_build_query($params);
    }

    /**
     * @param string $page
     * @param array $params
     */
    public function redirect(string $page, array $params = [])
    {
        header('Location: ' . $this->url($page, $params));
        exit;
    }

    /**
     * @param string $view
     * @param array $params
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $view, array $params = [])
    {
        return $this->twig->render($view, $params);
    }
}

