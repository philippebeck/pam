<?php

namespace Pam\Controller\Service;

/**
 * Class ArrayManager
 * @package Pam\Controller\Service
 */
class ArrayManager
{
    /**
     * @param array $array
     * @param string $key
     * @return array
     */
    public function getArrayElements(array $array, string $key = "category")
    {
        $elements = [];

        foreach ($array as $element) {
            $elements[$element[$key]][] = $element;
        }

        return $elements;
    }
}
