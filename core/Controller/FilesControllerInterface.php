<?php

namespace Pam\Controller;

/**
 * Interface FilesControllerInterface
 * @package Pam\Controller
 */
interface FilesControllerInterface
{
    /**
     * @return mixed
     */
    public function getFileArray();

    /**
     * @param string $var
     * @return mixed
     */
    public function getFileVar(string $var);

    /**
     * @param $fileDir
     * @return mixed
     */
    public function uploadFile($fileDir);
}

