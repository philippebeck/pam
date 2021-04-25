<?php

namespace Pam\Controller;

use Exception;
use ReCaptcha\ReCaptcha;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

/**
 * Class ServiceController
 * @package Pam\Controller
 */
abstract class ServiceController extends GlobalsController
{

    // ******************** API ******************** \\

    /**
     * Get Data from an API with Curl
     * @param string $query
     * @return mixed
     */
    protected function getApiData(string $query)
    {
        $curl = curl_init($query);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        $json = curl_exec($curl);

        curl_close($curl);

        return json_decode($json, true);
    }

    // ******************** IMAGE ******************** \\

    /**
     * Get Converted Image from Image Type with Input then Output
     * @param string $imgSrc
     * @param string $imgType
     * @param string $imgDest
     * @return bool|string
     */
    protected function getConvertedImage(string $imgSrc, string $imgType, string $imgDest)
    {
        try {
            switch ($imgType) {
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

            return $this->getOutputImage($this->getInputImage($imgSrc), $imgType, $imgDest);

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Get Extension Type from Uploaded File
     * @return string
     */
    protected function getExtension()
    {
        try {
            switch ($this->getFiles("type")) {
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
                    throw new Exception("The File Type : " . $this->getFiles("type") . " is not accepted...");
            }

            return $fileExtension;

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Get Name for File from Uploaded File or Parameter
     * @param string $fileDir
     * @param string|null $fileName
     * @return string
     */
    protected function getFilename(string $fileDir, string $fileName = null)
    {
        if ($fileName === null) {

            return $fileDir . $this->getFiles("name");
        }

        return $fileDir . $fileName . $this->getExtension();
    }

    /**
     * Get Image Type from the Source Image
     * @param string $img
     * @return bool|false|int
     */
    protected function getImageType(string $img)
    {
        if (exif_imagetype($img) === false) {

            return false;
        }

        return exif_imagetype($img);
    }

    /**
     * Get Resource Image from the Source Image
     * @param string $img
     * @return false|resource|string
     */
    protected function getInputImage(string $img)
    {
        try {
            switch ($this->getImageType($img)) {
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
     * Get Render Image from the Resource Image
     * @param $imgSrc
     * @param int $imgType
     * @param string $imgDest
     * @return bool|string
     */
    protected function getOutputImage($imgSrc, int $imgType, string $imgDest) 
    {
        try {
            switch ($imgType) {
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
     * Get A Thumbnail from the Source Image with Options for Width & Replacing
     * @param string $img
     * @param int $width
     * @param string|null $thumbnail
     * @return bool|string
     */
    protected function getThumbnail(string $img, int $width = 300, string $thumbnail = null)
    {
        if ($thumbnail === null) {
            $thumbnail = $img;
        }

        $inputImg   = $this->getInputImage($img);
        $imgScaled  = imagescale($inputImg, $width);
        $imgType    = $this->getImageType($img);

        return $this->getOutputImage($imgScaled, $imgType, $thumbnail);
    }

    /**
     * Set Uploaded File to Save Destination
     * @param string $fileDir
     * @param string|null $fileName
     * @return mixed|string
     */
    protected function getUploadedFile(string $fileDir, string $fileName = null, int $fileSize = 50000000) {
        $file = $this->getFiles("file");

        try {
            if (!isset($file["error"]) || is_array($file["error"])) {
                throw new Exception("Invalid parameters...");
            }

            if ($file["size"] > $fileSize) {
                throw new Exception("Exceeded filesize limit...");
            }

            if (!move_uploaded_file($file["tmp_name"], $this->getFilename($fileDir, $fileName))) {
                throw new Exception("Failed to move uploaded file...");
            }

            return $file["name"];

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    // ******************** MAILER ******************** \\

    /**
     * Send Mail with SwiftMailer
     * @param array $mail
     * @return int
     */
    public function sendMail(array $mail)
    {
        $transport = (new Swift_SmtpTransport())
            ->setHost(MAIL_HOST)
            ->setPort(MAIL_PORT)
            ->setUsername(MAIL_FROM)
            ->setPassword(MAIL_PASSWORD)
        ;

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message())
            ->setSubject($mail["subject"])
            ->setFrom([MAIL_FROM => MAIL_USERNAME])
            ->setTo([MAIL_TO => MAIL_USERNAME, $mail["email"] => $mail["name"]])
            ->setBody($mail["message"])
        ;

        return $mailer->send($message);
    }
}
