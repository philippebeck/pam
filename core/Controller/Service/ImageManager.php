<?php

namespace Pam\Controller\Service;

use Exception;

/**
 * Class ImageManager
 * @package Pam\Controller\Service
 */
class ImageManager
{
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
    public function inputImage(string $img)
    {
        try {
            switch ($this->getImageType($img)) {
                case IMAGETYPE_BMP:
                    $imgInput = imagecreatefrombmp($img);
                    break;

                case IMAGETYPE_GIF:
                    $imgInput =  imagecreatefromgif($img);
                    break;

                case IMAGETYPE_JPEG:
                    $imgInput =  imagecreatefromjpeg($img);
                    break;

                case IMAGETYPE_PNG:
                    $imgInput =  imagecreatefrompng($img);
                    break;

                case IMAGETYPE_WEBP:
                    $imgInput = imagecreatefromwebp($img);
                    break;

                default:
                    throw new Exception("Image Type not accepted to Input the Image...");
            }

            return $imgInput;

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * @param $imgSrc
     * @param int $imgType
     * @param string $imgDest
     * @return bool|string
     */
    public function outputImage($imgSrc, int $imgType, string $imgDest)
    {
        try {
            switch ($imgType) {
                case IMAGETYPE_BMP:
                    $imgOutput = imagebmp($imgSrc, $imgDest);
                    break;

                case IMAGETYPE_GIF:
                    $imgOutput = imagegif($imgSrc, $imgDest);
                    break;

                case IMAGETYPE_JPEG:
                    $imgOutput = imagejpeg($imgSrc, $imgDest);
                    break;

                case IMAGETYPE_PNG:
                    $imgOutput = imagepng($imgSrc, $imgDest);
                    break;

                case IMAGETYPE_WEBP:
                    $imgOutput = imagewebp($imgSrc, $imgDest);
                    break;

                default:
                    throw new Exception("Image Type not accepted to Output the Image...");
            }

            return $imgOutput;

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * @param string $imgSrc
     * @param string $imgType
     * @param string $imgDest
     * @return bool|string
     */
    public function convertImage(string $imgSrc, string $imgType, string $imgDest)
    {
        try {
            switch ($imgType) {
                case ".bmp":
                    $imgType = IMAGETYPE_BMP;
                    break;

                case ".gif":
                    $imgType = IMAGETYPE_GIF;
                    break;

                case ".jpg":
                case ".jpeg":
                    $imgType = IMAGETYPE_JPEG;
                    break;

                case ".png":
                    $imgType = IMAGETYPE_PNG;
                    break;

                case ".webp":
                    $imgType = IMAGETYPE_WEBP;
                    break;

                default:
                    throw new Exception("Image Type not accepted to Convert the Image...");
            }

            return $this->outputImage($this->inputImage($imgSrc), $imgType, $imgDest);

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

        $imgScaled = imagescale($this->inputImage($img), $width);

        return $this->outputImage($imgScaled, $this->getImageType($img), $thumbnail);
    }
}
