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
        if ($fileName === null) {
            $dest = $fileDir . $this->file["name"];
        } else {
            $dest = $fileDir . $fileName . $this->setFileExtension();
        }

        try {
            if (!isset($this->file["error"]) || is_array($this->file["error"])) {
                throw new Exception("Invalid parameters...");
            }

            if ($this->file["size"] > $fileSize) {
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
     * @param string $img
     * @return false|resource|string
     */
    public function createImage(string $img)
    {
        try {
            switch ($this->getImageType($img)) {
                case IMAGETYPE_JPEG:
                    return imagecreatefromjpeg($img);
                    break;

                case IMAGETYPE_PNG:
                    return imagecreatefrompng($img);
                    break;

                case IMAGETYPE_GIF:
                    return imagecreatefromgif($img);
                    break;

                default:
                    throw new Exception("Image Type not accepted to Create the Image...");
            }

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
                    return imagejpeg($imgSrc, $imgDest);
                    break;

                case IMAGETYPE_PNG:
                    return imagepng($imgSrc, $imgDest);
                    break;

                case IMAGETYPE_GIF:
                    return imagegif($imgSrc, $imgDest);
                    break;

                default:
                    throw new Exception("Image Type not accepted to Output the Image...");
            }

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * @param string $img
     * @param int $width
     * @param string|null $thumbnail
     * @return bool|string
     */
    public function makeThumbnail(string $img, int $width = 300, string $thumbnail = null)
    {
        if ($thumbnail === null) {
            $thumbnail = $img;
        }

        $imgScaled = imagescale($this->createImage($img), $width);

        return $this->outputImage($this->getImageType($img), $imgScaled, $thumbnail);
    }
}
