<?php

namespace Pam\Controller;

use Exception;

/**
 * Class GlobalsController
 * @package Pam\Controller
 */
abstract class GlobalsController
{
    /**
     * @var array
     */
    private $alert = [];

    /**
     * @var array
     */
    private $cookie = [];

    /**
     * @var array
     */
    private $env = [];

    /**
     * @var array
     */
    private $file = [];

    /**
     * @var array
     */
    private $files = [];

    /**
     * @var array
     */
    private $get = [];

    /**
     * @var array
     */
    private $post = [];

    /**
     * @var array
     */
    private $request = [];

    /**
     * @var array
     */
    private $server = [];

    /**
     * @var array
     */
    private $session = [];

    /**
     * @var array
     */
    private $user = [];

    /**
     * GlobalsController Constructor
     * Assign all Globals to Properties
     * With some Checking for Files & Session
     */
    public function __construct()
    {
        $this->cookie   = filter_input_array(INPUT_COOKIE) ?? [];
        $this->env      = filter_input_array(INPUT_ENV) ?? [];
        $this->get      = filter_input_array(INPUT_GET) ?? [];
        $this->post     = filter_input_array(INPUT_POST) ?? [];
        $this->server   = filter_input_array(INPUT_SERVER) ?? [];

        $this->files    = filter_var_array($_FILES) ?? [];
        $this->request  = filter_var_array($_REQUEST) ?? [];

        if (isset($this->files["file"])) {
            $this->file = $this->files["file"];
        }

        if (array_key_exists("alert", $_SESSION) === false) {
            $_SESSION["alert"] = [];
        }

        $this->session  = filter_var_array($_SESSION) ?? [];
        $this->alert    = $this->session["alert"];

        if (isset($this->session["user"])) {
            $this->user = $this->session["user"];
        }
    }

    // ******************** SETTERS ******************** \\

    /**
     * Set Cookie
     * @param string $name
     * @param string $value
     * @param int $expire
     */
    protected function setCookie(string $name, string $value = "", int $expire = 0) {

        if ($expire === 0) {
            $expire = time() + 3600;
        }

        setcookie($name, $value, $expire, "/");
    }

    /**
     * Set User Session or User Alert
     * @param array $user
     * @param bool $alert
     */
    protected function setSession(array $user, bool $session = false)
    {
        if ($session === false) {

            $_SESSION["alert"] = $user;

        } elseif ($session === true) {

            if (isset($user["pass"])) {
                unset($user["pass"]);
    
            } elseif (isset($user["password"])) {
                unset($user["password"]);
            }
    
            $_SESSION["user"] = $user;
        }
    }

    // ******************** CHECKERS ******************** \\

    /**
     * Check User Alert or User Session
     * @param bool $session
     * @return bool
     */
    protected function checkSession(bool $session = false)
    {
        if ($session === false) {

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
     * @param bool $message
     * @return string|void
     */
    protected function getAlert(bool $message = true)
    {
        if (isset($this->alert)) {

            if ($message !== true) {

                return $this->alert["type"] ?? "";
            }

            echo filter_var($this->alert["message"]);

            unset($_SESSION["alert"]);
        }
    }

    /**
     * Get Cookie Array or Cookie Var
     * @param null|string $var
     * @return array|string
     */
    protected function getCookie(string $var = null)
    {
        if ($var === null) {

            return $this->cookie;
        }
        
        return $this->cookie[$var] ?? "";
    }

    /**
     * Get Env Array or Env Var
     * @param null|string $var
     * @return array|string
     */
    protected function getEnv(string $var = null)
    {
        if ($var === null) {

            return $this->env;
        }
        
        return $this->env[$var] ?? "";
    }

    /**
     * Get Files Array or File Var
     * @param null|string $var
     * @return array|string
     */
    protected function getFiles(string $var = null)
    {
        if ($var === null) {

            return $this->files;
        }

        if ($var === "file") {

            return $this->file;
        }
        
        return $this->file[$var] ?? "";
    }

    /**
     * Get Get Array or Get Var
     * @param null|string $var
     * @return array|string
     */
    protected function getGet(string $var = null)
    {
        if ($var === null) {

            return $this->get;
        }
        
        return $this->get[$var] ?? "";
    }

    /**
     * Get Post Array or Post Var
     * @param null|string $var
     * @return array|string
     */
    protected function getPost(string $var = null)
    {
        if ($var === null) {

            return $this->post;
        }

        return $this->post[$var] ?? "";
    }

    /**
     * Get Request Array or Request Var
     * @param null|string $var
     * @return array|string
     */
    protected function getRequest(string $var = null)
    {
        if ($var === null) {

            return $this->request;
        }
        
        return $this->request[$var] ?? "";
    }

    /**
     * Get Server Array or Server Var
     * @param null|string $var
     * @return array|string
     */
    protected function getServer(string $var = null)
    {
        if ($var === null) {

            return $this->server;
        }
        
        return $this->server[$var] ?? "";
    }

    /**
     * Get Session Array or User Var
     * @param null|string $var
     * @return array|string
     */
    protected function getSession(string $var = null)
    {
        if ($var === null) {

            return $this->session;
        }

        if ($var === "user") {

            return $this->user;
        }

        if (!$this->checkSession(true)) {
            $this->user[$var] = null;
        }
        
        return $this->user[$var] ?? "";
    }

    // ******************** DESTROYER ******************** \\

    /**
     * Destroy Cookie or Session
     * @param string $name
     */
    protected function destroyGlobal(string $name = null)
    {
        if ($name === null) {

            $_SESSION["user"] = [];
            session_destroy();

        } elseif ($this->cookie[$name] !== null) {

            $this->setCookie($name, "", time() - 3600);
        }
    }
}
