<?php

namespace Pam\View;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class TwigExtension
 * @package Pam\View
 */
class TwigExtension extends AbstractExtension
{
    /**
     * @var array
     */
    private $get = [];

    /**
     * @var array
     */
    private $session = [];

    /**
     * @var array
     */
    private $user = [];

    /**
     * @var array
     */
    private $alert = [];

    /**
     * TwigExtension constructor
     */
    public function __construct()
    {
        $this->get      = filter_input_array(INPUT_GET) ?? [];
        $this->session  = filter_var_array($_SESSION) ?? [];
        $this->alert    = $this->session["alert"];

        if (isset($this->session["user"])) {
            $this->user = $this->session["user"];
        }
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction("checkIsAdmin", [$this, "checkIsAdmin"]),
            new TwigFunction("cleanString", [$this, "cleanString"]),
            new TwigFunction("getAlertType", [$this, "getAlertType"]),
            new TwigFunction("getAlertMessage", [$this, "getAlertMessage"]),
            new TwigFunction("getGet", [$this, "getGet"]),
            new TwigFunction("getUserVar", [$this, "getUserVar"]),
            new TwigFunction("hasAlert", [$this, "hasAlert"]),
            new TwigFunction("isLogged", [$this, "isLogged"]),
            new TwigFunction("redirect", [$this, "redirect"]),
            new TwigFunction("url", [$this, "url"])
        );
    }

    /**
     * @return bool
     */
    public function checkIsAdmin()
    {
        $isAdmin = false;

        if (isset($this->session["user"]["admin"])) {

            if ($this->session["admin"] === true || $this->session["admin"] === 1) {
                $isAdmin = true;
            }

        } elseif (isset($this->session["user"]["role"])) {

            if ($this->session["role"] === 1 || $this->session["role"] === "admin") {
                $isAdmin = true;
            }
        }

        return $isAdmin;
    }

    /**
     * @param string $string
     * @return string
     */
    public function cleanString(string $string)
    {
        $string = str_replace("_", " ", $string);

        return ucwords($string);
    }

    public function getAlertMessage()
    {
        if (isset($this->alert)) {

            echo filter_var($this->alert["message"]);

            unset($_SESSION["alert"]);
        }
    }

    /**
     * @return mixed
     */
    public function getAlertType()
    {
        if (isset($this->alert)) {

            return $this->alert["type"];
        }
    }

    /**
     * @param $var
     * @return mixed
     */
    public function getGet(string $var = null)
    {
        if ($var === null) {

            return $this->get;
        }

        return $this->get[$var] ?? "";
    }

    /**
     * @param $var
     * @return mixed
     */
    public function getUserVar(string $var)
    {
        if ($this->isLogged() === false) {
            $this->user[$var] = null;
        }

        return $this->user[$var] ?? "";
    }

    /**
     * @return bool
     */
    public function hasAlert()
    {
        return empty($this->alert) === false;
    }

    /**
     * @return bool
     */
    public function isLogged()
    {
        if (array_key_exists("user", $this->session)) {

            if (!empty($this->user)) {

                return true;
            }
        }
        return false;
    }

    /**
     * @param string $access
     * @param array $params
     */
    public function redirect(string $access, array $params = [])
    {
        header("Location: " . $this->url($access, $params));

        exit;
    }

    /**
     * @param string $access
     * @param array $params
     * @return string
     */
    public function url(string $access, array $params = [])
    {
        $params["access"] = $access;

        return "index.php?" . http_build_query($params);
    }

}
