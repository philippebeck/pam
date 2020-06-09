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
     * @return string
     */
    public function setFileExtension()
    {
        try {
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
                    throw new Exception("Image Type not Set...");
            }

            return $fileExt;

        } catch (Exception $e) {

            return $e->getMessage();
        }
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
            $dest = $fileDir . $fileName . $this->setFileExtension();
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
     * @param string $img
     * @return bool|false|int
     */
    public function getImageType(string $img)
    {
        if (exif_imagetype($img) === false) {

            return false;
        }

        return exif_imagetype($img);
    }

    /**
     * @param int $imgType
     * @param string $imgSrc
     * @return false|resource|string
     */
    public function createImage(int $imgType, string $imgSrc)
    {
        try {
            switch ($imgType) {
                case IMAGETYPE_JPEG:
                    $imgCreated = imagecreatefromjpeg($imgSrc);
                    break;
                case IMAGETYPE_PNG:
                    $imgCreated = imagecreatefrompng($imgSrc);
                    break;
                case IMAGETYPE_GIF:
                    $imgCreated = imagecreatefromgif($imgSrc);
                    break;
                default:
                    throw new Exception("Image Type not accepted to Create the Image...");
            }

            return $imgCreated;

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * @param int $imgType
     * @param $imgSrc
     * @param string $imgDest
     * @return bool|string
     */
    public function outputImage(int $imgType, $imgSrc, string $imgDest)
    {
        try {
            switch ($imgType) {
                case IMAGETYPE_JPEG:
                    $isOutput = imagejpeg($imgSrc, $imgDest);
                    break;
                case IMAGETYPE_PNG:
                    $isOutput = imagepng($imgSrc, $imgDest);
                    break;
                case IMAGETYPE_GIF:
                    $isOutput = imagegif($imgSrc, $imgDest);
                    break;
                default:
                    throw new Exception("Image Type not accepted to Output the Image...");
            }

            return $isOutput;

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * @param string $imgSrc
     * @param int $tnWidth
     * @param string|null $imgDest
     * @return bool|string
     */
    public function makeThumbnail(string $imgSrc, int $tnWidth = 300, string $thumbnail = null)
    {
        if ($thumbnail === null) {
            $thumbnail = $imgSrc;
        }

        $imgType      = $this->getImageType($imgSrc);
        $imgCreated   = $this->createImage($imgType, $imgSrc);
        $imgScaled    = imagescale($imgCreated, $tnWidth);

        return $this->outputImage($imgType, $imgScaled, $thumbnail);
    }
}
