<?php

namespace Pam\Controller;

use Pam\View\TwigExtension;
use ReCaptcha\ReCaptcha;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

/**
 * Class MainController
 * @package Pam\Controller
 */
abstract class MainController extends ServiceController
{
    /**
     * @var Environment|null
     */
    protected $twig = null;

    /**
     * MainController constructor
     * Get the Globals Constructor & Set Twig Template Engine
     */
    public function __construct()
    {
        parent::__construct();

        $loader = new FilesystemLoader(VIEW_PATH);
        $this->twig = new Environment($loader, ["cache" => VIEW_CACHE]);

        $this->twig->addExtension(new TwigExtension());
    }

    /**
     * Get an Array of Elements Indexes by Category or Another Key
     * @param array $array
     * @param string $key
     * @return array
     */
    protected function getArrayElements(array $array, string $key = "category") 
    {
        $elements = [];

        foreach ($array as $element) {

            $elements[$element[$key]][] = $element;
        }

        return $elements;
    }

    // ******************** REDIRECT ******************** \\

    /**
     * Get the Access Key to Build the Http Query
     * @param string $access
     * @param array $params
     * @return string
     */
    protected function url(string $access, array $params = [])
    {
        $params[ACCESS_KEY] = $access;

        return "index.php?" . http_build_query($params);
    }

    /**
     * Use the Url Method to Redirect to Another Controller
     * @param string $access
     * @param array $params
     */
    protected function redirect(string $access, array $params = [])
    {
        header("Location: " . $this->url($access, $params));

        exit;
    }

    // ******************** RENDER ******************** \\

    /**
     * Shortcut to the Twig Render Method
     * @param string $view
     * @param array $params
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    protected function render(string $view, array $params = [])
    {
        return $this->twig->render($view, $params);
    }

    // ******************** SECURITY ******************** \\

    /**
     * Check Recaptcha Response
     * @param string $response
     * @return bool
     */
    protected function checkRecaptcha(string $response)
    {
        $recaptcha = new ReCaptcha(RECAPTCHA_TOKEN);

        $result = $recaptcha
            ->setExpectedHostname($this->getServer("SERVER_NAME"))
            ->verify($response, $this->getServer("REMOTE_ADDR")
        );

        return $result->isSuccess();
    }

    /**
     * Check Admin Status or Login Status
     * @return bool
     */
    protected function checkAdmin()
    {
        if ($this->checkArray($this->getSession("user"), "admin")) {
            if ($this->getSession("admin") === true || $this->getSession("admin") === 1) {

                return true;
            }
        } 
        
        if ($this->checkArray($this->getSession("user"), "role")) {
            if ($this->getSession("role") === 1 || $this->getSession("role") === "admin") {

                return true;
            }
        }

        if ($this->checkSession(true)) {

            return true;
        }

        $this->setSession(["You must be logged in as Admin to access to the administration", "black"]);

        return false;
    }

    // ******************** STRING ******************** \\

    /**
     * Get a Clean String with an Optional Specific Case
     * @param string $string
     * @param string $case
     * @return string
     */
    protected function getString(string $string, string $case = "") 
    {
        $string = (string) trim(strtolower($string));

        $string = str_replace(["ç"], "c", str_replace(["à", "â", "ä"], "a", $string));
        $string = str_replace(["î", "ï"], "i", str_replace(["é", "è", "ê", "ë"], "e", $string));
        $string = str_replace(["ù", "û", "ü"], "u", str_replace(["ô", "ö"], "o", $string));

        $string = preg_replace("/ +/", " ", preg_replace("/[^A-Za-z0-9\ ]/", " ", $string));

        return $this->getStringCase($string, $case);
    }

    /**
     * Switch between Major Cases to Get a Converted String
     * @param string $string
     * @param string $case
     */
    private function getStringCase(string $string, string $case)
    {
        switch ($case) {
            case "alpha": 
                $string = preg_replace("/[^A-Za-z]/", "", $string);
                break;

            case "camel":
                $string = lcfirst(str_replace(" ", "", ucwords($string)));
                break;

            case "dot":
                $string = str_replace(" ", ".", $string);
                break;

            case "pascal":
                $string = str_replace(" ", "", ucwords($string));
                break;

            case "path":
                $string = str_replace(" ", "/", $string);
                break;

            case "snake":
                $string = str_replace(" ", "_", $string);
                break;

            default:
                $string = str_replace(" ", "-", $string);
        }

        return $string;
    }
}
