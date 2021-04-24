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
    
    // ******************** ARRAY ******************** \\

    /**
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

    // ******************** CURL ******************** \\

    /**
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
     * @param string $img
     * @return false|resource|string
     */
    protected function getInputImage(string $img)
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
    protected function getOutputImage($imgSrc, int $imgType, string $imgDest) 
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
    protected function getConvertImage(string $imgSrc, string $imgType, string $imgDest)
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

            $inputImg = $this->getInputImage($imgSrc);

            return $this->getOutputImage($inputImg, $imgType, $imgDest);

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

    // ******************** MAIL ******************** \\

    /**
     * @param array $mail
     * @return int
     */
    public function sendMessage(array $mail)
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

    // ******************** SECURITY ******************** \\

    /**
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
     * @return bool
     */
    protected function checkIsAdmin()
    {
        $isAdmin = false;

        if ($this->checkUser("admin")) {

            if ($this->getUser("admin") === true || $this->getUser("admin") === 1) {
                $isAdmin = true;
            }

        } elseif ($this->checkUser("role")) {

            if ($this->getUser("role") === 1 || $this->getUser("role") === "admin") {
                $isAdmin = true;
            }

        } else {
            if ($this->islogged() === true) {
                $isAdmin = true;
            }
        }

        if ($isAdmin === false) {
            $this->createAlert("You must be logged in as Admin to access to the administration");
        }

        return $isAdmin;
    }

    // ******************** STRING ******************** \\

    /**
     * @param string $string
     * @param string $case
     * @return string
     */
    protected function cleanString(string $string, string $case = "") 
    {
        $this->string = (string) strtolower(trim($string));
        $this->string = strtolower($string);

        $this->setStandardLetters();
        $this->setStandardCharacters();
        $this->setCase($case);

        return $this->string;
    }

    private function setStandardLetters()
    {
        $this->string = str_replace(array("à", "â", "ä"), "a", $this->string);
        $this->string = str_replace(array("ç"), "c", $this->string);
        $this->string = str_replace(array("é", "è", "ê", "ë"), "e", $this->string);
        $this->string = str_replace(array("î", "ï"), "i", $this->string);
        $this->string = str_replace(array("ô", "ö"), "o", $this->string);
        $this->string = str_replace(array("ù", "û", "ü"), "u", $this->string);
    }

    private function setStandardCharacters()
    {
        $this->string = preg_replace("/[^A-Za-z0-9\ ]/", " ", $this->string);
        $this->string = preg_replace("/ +/", " ", $this->string);
    }

    /**
     * @param string $case
     */
    private function setCase(string $case)
    {
        switch ($case) {
            case "alpha": 
                $this->setAlphaCase();
                break;
            case "camel":
                $this->setCamelCase();
                break;
            case "const":
                $this->setConstCase();
                break;
            case "cram":
                $this->setCramCase();
                break;
            case "dot":
                $this->setDotCase();
                break;
            case "enum":
                $this->setEnumCase();
                break;
            case "kebab":
                $this->setKebabCase();
                break;
            case "name":
                $this->setNameCase();
                break;
            case "pascal":
                $this->setPascalCase();
                break;
            case "path":
                $this->setPathCase();
                break;
            case "snake":
                $this->setSnakeCase();
                break;
            case "space":
                break;
            case "title":
                $this->setTitleCase();
                break;
            default:
                $this->setKebabCase();
        }
    }

    private function setAlphaCase()
    {
        $this->string = preg_replace("/[^A-Za-z]/", "", $this->string);
    }

    private function setCamelCase()
    {
        $this->string = ucwords($this->string);
        $this->string = str_replace(" ", "", $this->string);
        $this->string = lcfirst($this->string);
    }

    private function setConstCase()
    {
        $this->string = str_replace(" ", "_", $this->string);
        $this->string = strtoupper($this->string);
    }

    private function setCramCase()
    {
        $this->string = str_replace(" ", "", $this->string);
    }

    private function setDotCase()
    {
        $this->string = str_replace(" ", ".", $this->string);
    }

    private function setEnumCase()
    {
        $this->string = str_replace(" ", ":", $this->string);
    }

    private function setKebabCase()
    {
        $this->string = str_replace(" ", "-", $this->string);
    }

    private function setNameCase()
    {
        $this->string = preg_replace("/[^A-Za-z\ ]/", "", $this->string);
        $this->string = ucwords($this->string);
        $this->string = str_replace(" ", "-", $this->string);
    }

    private function setPascalCase()
    {
        $this->string = str_replace(" ", "", $this->string);
        $this->string = ucwords($this->string);
    }

    private function setPathCase()
    {
        $this->string = str_replace(" ", "/", $this->string);
    }

    private function setSnakeCase()
    {
        $this->string = str_replace(" ", "_", $this->string);
    }

    private function setTitleCase()
    {
        $this->string = ucwords($this->string);
    }
}
