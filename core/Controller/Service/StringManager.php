<?php

namespace Pam\Controller\Service;

/**
 * Class StringManager
 * @package Pam\Controller\Service
 */
class StringManager
{
    /**
     * @var string $string
     */
    private $string = "";

    /**
     * @param string $string
     * @param string $case
     * @return string
     */
    public function cleanString(string $string, string $case = "")
    {
        $this->string = (string) strtolower(trim($string));

        $this->setStandardLetters();
        $this->setStandardCharacters();
        $this->setCase($case);

        return $this->string;
    }

    private function setStandardLetters()
    {
        $this->string = str_replace(array("ù", "û", "ü"), "u",
            str_replace(array("ô", "ö"), "o",
                str_replace(array("î", "ï"), "i",
                    str_replace(array("é", "è", "ê", "ë"), "e",
                        str_replace(array("ç"), "c",
                            str_replace(array("à", "â", "ä"), "a", $this->string)
                        )
                    )
                )
            )
        );
    }

    private function setStandardCharacters()
    {
        $this->string = preg_replace("/ +/", " ",
            preg_replace("/[^A-Za-z0-9\ ]/", " ", $this->string)
        );
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
            case "dromedary":
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
            case "spinal":
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
            case "underscore":
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
        $this->string = lcfirst(str_replace(" ", "", ucwords($this->string)));
    }

    private function setConstCase()
    {
        $this->string = strtoupper(str_replace(" ", "_", $this->string));
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
        $this->string = str_replace(" ", "-", ucwords(
            preg_replace("/[^A-Za-z\ ]/", "", $this->string))
        );
    }

    private function setPascalCase()
    {
        $this->string = str_replace(" ", "", ucwords($this->string));
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
