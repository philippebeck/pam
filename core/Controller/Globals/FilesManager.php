<?php

namespace Pam\Controller\Globals;

use Exception;

/**
 * Class FilesManager
 * @package Pam\Controller\Globals
 */
class FilesManager
{
    /**
     * @var
     */
    private $files = null;

    /**
     * @var
     */
    private $file = null;

    /**
     * FilesManager constructor.
     */
    public function __construct()
    {
        $this->files = filter_var_array($_FILES);

        if (isset($this->files["file"])) {
            $this->file = $this->files["file"];
        }
    }

    /**
     * @return mixed
     */
    public function getFilesArray()
    {
        return $this->files;
    }

    /**
     * @param string $var
     * @return mixed
     */
    public function getFileVar(string $var)
    {
        return $this->file[$var];
    }

    /**
     * @param string $fileDir
     * @param string|null $fileName
     * @return string
     */
    public function setFileName(string $fileDir, string $fileName = null)
    {
        if ($fileName === null) {

            return $fileDir . $this->file["name"];
        }

        return $fileDir . $fileName . $this->setFileExtension();
    }

    /**
     * @return string
     */
    public function setFileExtension()
    {
        try {
            switch ($this->file["type"]) {
                case "image/jpeg":
                    return ".jpg";
                    break;

                case "image/png":
                    return ".png";
                    break;

                case "image/gif":
                    return ".gif";
                    break;

                default:
                    throw new Exception("The File Type : " . $this->file["type"] . " is not accepted...");
            }

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * @param string $fileDir
     * @param string|null $fileName
     * @return mixed|string
     */
    public function uploadFile(string $fileDir, string $fileName = null, int $fileSize = 50000000)
    {
        try {
            if (!isset($this->file["error"]) || is_array($this->file["error"])) {
                throw new Exception("Invalid parameters...");
            }

            if ($this->file["size"] > $fileSize) {
                throw new Exception("Exceeded filesize limit...");
            }

            if (!move_uploaded_file($this->file["tmp_name"], $this->setFileName($fileDir, $fileName))) {
                throw new Exception("Failed to move uploaded file...");
            }

            return $this->file["name"];

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }
}
