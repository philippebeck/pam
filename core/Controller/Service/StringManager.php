<?php

namespace Pam\Controller\Service;

/**
 * Class StringManager
 * @package Pam\Controller\Service
 */
class StringManager
{
    /**
     * @param string $string
     * @param bool $isLow
     * @return string|string[]|null
     */
    public function cleanString(string $string, bool $isLow = true)
    {
        $string =
            str_replace(" ", "-",
                str_replace(array("ù", "û", "ü"), "u",
                    str_replace(array("ô", "ö"), "o",
                        str_replace(array("î", "ï"), "i",
                            str_replace(array("é", "è", "ê", "ë"), "e",
                                str_replace(array("ç"), "c",
                                    str_replace(array("à", "â", "ä"), "a", $string)
                                )
                            )
                        )
                    )
                )
            );

        $string =
            preg_replace("/-+/", "-",
                preg_replace("/[^A-Za-z0-9\-]/", "", $string)
            );

        if ($isLow === true) {
            $string = strtolower($string);
        }

        return $string;
    }
}
