<?php

namespace Pam\Controller\Globals;

use Exception;

/**
 * Class FilesController
 * @package Pam\Controller
 */
class FilesController
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
     * FilesController constructor.
     */
    public function __construct()
    {
        $this->files = filter_var_array($_FILES);

        if (isset($this->files['file'])) {
            $this->file = $this->files['file'];
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
     * @param string $fileDir
     * @param string|null $fileName
     * @return mixed|string
     */
    public function uploadFile(string $fileDir, string $fileName = null)
    {
        if ($fileName === null) {
            $dest = $fileDir . $this->file["name"];
        } else {
            switch ($this->file["type"]) {
                case "image/jpeg":
                    $fileExt = ".jpg";
                    break;
                case "image/png":
                    $fileExt = ".png";
                    break;
                case "image/gif":
                    $fileExt = ".gif";
                    break;
                default:
                    throw new Exception("Image Type not accepted...");
            }
            $dest = $fileDir . $fileName . $fileExt;
        }

        try {
            if (!isset($this->file["error"]) || is_array($this->file["error"])) {
                throw new Exception("Invalid parameters...");
            }

            if ($this->file["size"] > 1000000) {
                throw new Exception("Exceeded filesize limit...");
            }

            if (!move_uploaded_file($this->file["tmp_name"], $dest)) {
                throw new Exception("Failed to move uploaded file...");
            }

            return $this->file["name"];

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * @param string $src
     * @param int $width
     * @param string|null $dest
     * @return bool|string
     */
    public function makeThumbnail(string $src, int $width = 300, string $dest = null)
    {
        if ($dest === null) {
            $dest = $src;
        }

        $imageType = exif_imagetype($src);

        try {
            switch ($imageType) {
                case IMAGETYPE_JPEG:
                    $imageCreate = imagecreatefromjpeg($src);
                    break;
                case IMAGETYPE_PNG:
                    $imageCreate = imagecreatefrompng($src);
                    break;
                case IMAGETYPE_GIF:
                    $imageCreate = imagecreatefromgif($src);
                    break;
                default:
                    throw new Exception("Image Type not accepted...");
            }

            $imageScale = imagescale($imageCreate, $width);

            switch ($imageType) {
                case IMAGETYPE_JPEG:
                    $img = imagejpeg($imageScale, $dest);
                    break;
                case IMAGETYPE_PNG:
                    $img = imagepng($imageScale, $dest);
                    break;
                case IMAGETYPE_GIF:
                    $img = imagegif($imageScale, $dest);
                    break;
                default:
                    throw new Exception("Something was Wrong with the Thumbnail...");
            }

            return $img;

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }
}
