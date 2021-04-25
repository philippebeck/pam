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
            new TwigFunction("redirect", [$this, "redirect"]),
            new TwigFunction("url", [$this, "url"]),
            new TwigFunction("checkAdmin", [$this, "checkAdmin"]),
            new TwigFunction("checkUser", [$this, "checkUser"]),
            new TwigFunction("getAlert", [$this, "getAlert"]),
            new TwigFunction("getGet", [$this, "getGet"]),
            new TwigFunction("getSession", [$this, "getSession"]),
            new TwigFunction("getString", [$this, "getString"])
        );
    }

    // ******************** REDIRECT ******************** \\

    /**
     * Use the Url Method to Redirect to Another Controller
     * @param string $access
     * @param array $params
     */
    public function redirect(string $access, array $params = [])
    {
        header("Location: " . $this->url($access, $params));

        exit;
    }

    /**
     * Get the Access Key to Build the Http Query
     * @param string $access
     * @param array $params
     * @return string
     */
    public function url(string $access, array $params = [])
    {
        $params["access"] = $access;

        return "index.php?" . http_build_query($params);
    }

    // ******************** CHECKERS ******************** \\

    /**
     * @return bool
     */
    public function checkAdmin()
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
     * Check User Alert or User Session
     * @param bool $alert
     * @return bool
     */
    public function checkUser(bool $alert = false)
    {
        if ($alert) {

            return empty($this->alert) === false;
        }

        if (array_key_exists("user", $this->session)) {

            if (!empty($this->user)) {

                return true;
            }
        }

        return false;
    }

    // ******************** GETTERS ******************** \\

    /**
     * Get Alert Type or Alert Message
     * @param bool $type
     * @return string|void
     */
    public function getAlert(bool $type = false)
    {
        if (isset($this->alert)) {

            if ($type) {

                return $this->alert["type"] ?? "";
            }

            echo filter_var($this->alert["message"]);

            unset($_SESSION["alert"]);
        }
    }

    /**
     * Get Get Array or Get Var
     * @param null|string $var
     * @return array|string
     */
    public function getGet(string $var = null)
    {
        if ($var === null) {

            return $this->get;
        }
        
        return $this->get[$var] ?? "";
    }

    /**
     * Get Session Array, User Array or User Var
     * @param null|string $var
     * @return array|string
     */
    public function getSession(string $var = null)
    {
        if ($var === null) {

            return $this->session;
        }

        if ($var === "user") {

            return $this->user;
        }

        if (!$this->checkUser()) {
            $this->user[$var] = null;
        }
        
        return $this->user[$var] ?? "";
    }

    /**
     * Get a 
     * @param string $string
     * @return string
     */
    public function getString(string $string)
    {
        $string = str_replace("_", " ", $string);

        return ucwords($string);
    }
}
