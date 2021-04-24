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
     * GlobalsController constructor
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
     * @param string $fileDir
     * @param string|null $fileName
     * @return string
     */
    protected function setFileName(string $fileDir, string $fileName = null)
    {
        if ($fileName === null) {

            return $fileDir . $this->file["name"];
        }

        return $fileDir . $fileName . $this->setFileExtension();
    }

    /**
     * @return string
     */
    protected function setFileExtension()
    {
        try {
            switch ($this->file["type"]) {
                case "image/bmp":
                    $fileExtension = ".bmp";
                    break;

                case "image/gif":
                    $fileExtension =  ".gif";
                    break;

                case "image/jpeg":
                    $fileExtension =  ".jpg";
                    break;

                case "image/png":
                    $fileExtension =  ".png";
                    break;

                case "image/webp":
                    $fileExtension =  ".webp";
                    break;

                default:
                    throw new Exception("The File Type : " . $this->file["type"] . " is not accepted...");
            }

            return $fileExtension;

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * @param array $session
     */
    protected function setSession(array $session)
    {
        if (isset($session["alert"]) || isset($session["message"])) {

            $_SESSION["alert"] = $session;

        } elseif (isset($session["email"]) || isset($session["user"])) {

            if (isset($session["pass"])) {
                unset($session["pass"]);
    
            } elseif (isset($session["password"])) {
                unset($session["password"]);
            }
    
            $_SESSION["user"] = $session;
        }
    }

    /**
     * @param string $fileDir
     * @param string|null $fileName
     * @return mixed|string
     */
    protected function setUploadedFile(string $fileDir, string $fileName = null, int $fileSize = 50000000) {
        try {
            if (
                !isset($this->file["error"]) 
                || is_array($this->file["error"])
            ) {
                throw new Exception("Invalid parameters...");
            }

            if ($this->file["size"] > $fileSize) {
                throw new Exception("Exceeded filesize limit...");
            }

            if (
                !move_uploaded_file(
                    $this->file["tmp_name"], 
                    $this->setFileName($fileDir, $fileName)
                )
            ) {
                throw new Exception("Failed to move uploaded file...");
            }

            return $this->file["name"];

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    // ******************** CHECKERS ******************** \\

    /**
     * @return bool
     */
    protected function checkAlert()
    {
        return empty($this->alert) === false;
    }

    /**
     * @param array $global
     * @param string $var
     * @return bool
     */
    protected function checkGlobal(array $global, string $var = null)
    {
        if (!empty($global)) {

            if ($var === null) {

                return true;
            }

            if (in_array($var, $global) && !empty($global[$var])) {

                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function checkUser()
    {
        if (array_key_exists("user", $this->session)) {

            if (!empty($this->user)) {

                return true;
            }
        }

        return false;
    }

    // ******************** GETTERS ******************** \\

    /**
     * @return string
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
     * @return array|mixed
     */
    protected function getCookie(string $var = null)
    {
        if ($var === null) {

            return $this->cookie;
        }
        
        return $this->cookie[$var] ?? "";
    }

    /**
     * @return array|mixed
     */
    protected function getEnv(string $var = null)
    {
        if ($var === null) {

            return $this->env;
        }
        
        return $this->env[$var] ?? "";
    }

    /**
     * @return array|mixed
     */
    protected function getFiles(string $var = null)
    {
        if ($var === null) {

            return $this->files;
        }
        
        return $this->file[$var] ?? "";
    }

    /**
     * @return array|mixed
     */
    protected function getGet(string $var = null)
    {
        if ($var === null) {

            return $this->get;
        }
        
        return $this->get[$var] ?? "";
    }

    /**
     * @param string $var
     * @return mixed
     */
    protected function getPost(string $var = null)
    {
        if ($var === null) {

            return $this->post;
        }

        return $this->post[$var] ?? "";
    }

    /**
     * @return array|mixed
     */
    protected function getRequest(string $var = null)
    {
        if ($var === null) {

            return $this->request;
        }
        
        return $this->request[$var] ?? "";
    }

    /**
     * @return array|mixed
     */
    protected function getServer(string $var = null)
    {
        if ($var === null) {

            return $this->server;
        }
        
        return $this->server[$var] ?? "";
    }

    /**
     * @return array|mixed
     */
    protected function getSession(string $var = null)
    {
        if ($var === null) {

            return $this->session;
        }

        if ($this->checkUser() === false) {
            $this->user[$var] = null;
        }
        
        return $this->user[$var] ?? "";
    }

    // ******************** DESTROYER ******************** \\

    /**
     * Destroy cookie or session
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
