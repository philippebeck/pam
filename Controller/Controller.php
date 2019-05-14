<?php

namespace Pam\Controller;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Pam\Helper\Session;

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
     * Controller constructor
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
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
        if ($_FILES['file']['error'] > 0) {
            htmlspecialchars(Session::createAlert('Erreur lors du transfert du fichier...', 'warning'));
        } else {
            $fileName = $_FILES['file']['name'];

            $filePath = dirname(dirname(dirname(dirname(__DIR__)))) . "/public/{$fileDir}/{$fileName}";

            $result  = move_uploaded_file($_FILES['file']['tmp_name'], $filePath);

            if ($result) {
                htmlspecialchars(Session::createAlert('Transfert du nouveau fichier réussi !', 'valid'));
            }

            return $fileName;
        }
    }
}

