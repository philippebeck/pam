<?php

namespace Pam\Controller;

use http\Exception\RuntimeException;
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
        $file = filter_var_array($_FILES['file']);

        try {
            if (!isset($file['error']) || is_array($file['error'])) {
                throw new RuntimeException('Invalid parameters...');
            }

            switch ($file['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('No file sent...');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('Exceeded filesize limit...');
                default:
                    throw new RuntimeException('Unknown errors...');
            }

            if ($file['size'] > 1000000) {
                throw new RuntimeException('Exceeded filesize limit...');
            }

            if (!move_uploaded_file(filter_var($_FILES['file']['tmp_name']), "{$fileDir}/{$file['name']}")) {
                $this->cookie->createAlert('Failed to move uploaded file...');
                //throw new RuntimeException('Failed to move uploaded file...');
            }

            $this->cookie->createAlert('File is uploaded successfully !');

            return $file['name'];

        } catch (RuntimeException $e) {

            $this->cookie->createAlert($e->getMessage());
        }
    }
}


