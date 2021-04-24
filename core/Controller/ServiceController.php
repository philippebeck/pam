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
    /**
     * @var string $string
     */
    private $string = "";
    
    // ******************** SETTERS ******************** \\

    /**
     * Replace Special Letters with standard Letters
     * Then Replace Special Characters with Spaces
     */
    private function setStandardCharacters()
    {
        $this->string = str_replace(["à", "â", "ä"], "a", $this->string);
        $this->string = str_replace(["ç"], "c", $this->string);
        $this->string = str_replace(["é", "è", "ê", "ë"], "e", $this->string);
        $this->string = str_replace(["î", "ï"], "i", $this->string);
        $this->string = str_replace(["ô", "ö"], "o", $this->string);
        $this->string = str_replace(["ù", "û", "ü"], "u", $this->string);

        $this->string = preg_replace("/[^A-Za-z0-9\ ]/", " ", $this->string);
        $this->string = preg_replace("/ +/", " ", $this->string);
    }

    /**
     * Switch between Major Cases to Convert a String
     * @param string $case
     */
    private function setCase(string $case)
    {
        switch ($case) {
            case "alpha": 
                $this->string = preg_replace("/[^A-Za-z]/", "", $this->string);
                break;

            case "camel":
                $this->string = lcfirst(str_replace(" ", "", ucwords($this->string)));
                break;

            case "dot":
                $this->string = str_replace(" ", ".", $this->string);
                break;

            case "pascal":
                $this->string = str_replace(" ", "", ucwords($this->string));
                break;

            case "path":
                $this->string = str_replace(" ", "/", $this->string);
                break;

            case "snake":
                $this->string = str_replace(" ", "_", $this->string);
                break;

            default:
                $this->string = str_replace(" ", "-", $this->string);
        }
    }

    // ******************** CHECKERS ******************** \\

    /**
     * Check Recaptcha Response
     * @param string $response
     * @return bool
     */
    protected function checkRecaptcha(string $response)
    {
        $recaptcha = new ReCaptcha(RECAPTCHA_TOKEN);

        $result = $recaptcha
            ->setExpectedHostname($this->getServer("SERVER_NAME"))
            ->verify($response, $this->getServer("REMOTE_ADDR")
        );

        return $result->isSuccess();
    }

    /**
     * Check Admin Status or Login Status
     * @return bool
     */
    protected function checkAdmin()
    {
        if ($this->checkSession("admin")) {
            if ($this->getSession("admin") === true || $this->getSession("admin") === 1) {

                return true;
            }
        } 
        
        if ($this->checkSession("role")) {
            if ($this->getSession("role") === 1 || $this->getSession("role") === "admin") {

                return true;
            }
        }

        if ($this->checkSession("user")) {

            return true;
        }

        $this->setSession(["You must be logged in as Admin to access to the administration", "black"]);

        return false;
    }

    // ******************** GETTERS ******************** \\

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

    /**
     * Get an Array of Elements Indexes by Category or Another Key
     * @param array $array
     * @param string $key
     * @return array
     */
    protected function getArrayElements(array $array, string $key = "category") 
    {
        $elements = [];

        foreach ($array as $element) {

            $elements[$element[$key]][] = $element;
        }

        return $elements;
    }

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
     * Get a Clean String with an Optional Specific Case
     * @param string $string
     * @param string $case
     * @return string
     */
    protected function getString(string $string, string $case = "") 
    {
        $this->string = (string) trim($string);
        $this->string = strtolower($string);

        $this->setStandardCharacters();
        $this->setCase($case);

        return $this->string;
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
