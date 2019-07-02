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
    protected $twig;

    /**
     * @var CookieController
     */
    protected $cookie;

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
        $this->twig     = $twig;
        $this->cookie   = new CookieController();
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

    /**
     * @param string $fileDir
     * @return string
     */
    public function upload($fileDir)
    {
        $fileError = filter_var($_FILES['file']['error'], FILTER_SANITIZE_STRING);

        if ($fileError > 0) {
            $this->cookie->createAlert('File transfer error...', 'warning');

        } else {
            $fileName = filter_var($_FILES['file']['name'], FILTER_SANITIZE_STRING);
            $filePath = "{$fileDir}/{$fileName}";

            $result  = move_uploaded_file(filter_var($_FILES['file']['tmp_name'], FILTER_SANITIZE_STRING), $filePath);

            if ($result) {
                $this->cookie->createAlert('Transfer the new file successfully !', 'valid');
            }

            return $fileName;
        }
    }
}

