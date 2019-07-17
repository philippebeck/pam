<?php

namespace Pam\Controller;

use Exception;

/**
 * Class FilesController
 * @package Pam\Controller
 */
class FilesController implements FilesControllerInterface
{
    /**
     * @var
     */
    private $file;

    /**
     * FilesController constructor.
     */
    public function __construct()
    {
        $this->file = filter_var_array($_FILES['file']);
    }

    /**
     * @return mixed
     */
    public function getFileArray()
    {
        return $this->file;
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
     * @param $fileDir
     * @return mixed
     */
    public function uploadFile($fileDir)
    {
        try {
            if (!isset($this->file['error']) || is_array($this->file['error'])) {
                throw new Exception('Invalid parameters...');
            }

            if ($this->file['size'] > 1000000) {
                throw new Exception('Exceeded filesize limit...');
            }

            if (!move_uploaded_file($this->file['tmp_name'], "{$fileDir}/{$this->file['name']}")) {
                throw new Exception('Failed to move uploaded file...');
            }

            return $this->file['name'];

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }
}

