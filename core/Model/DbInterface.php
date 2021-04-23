<?php

namespace Pam\Model;

/**
 * Interface DbInterface
 * @package Pam\Model
 */
interface DbInterface
{
    /**
     * @param string $query
     * @param array $params
     * @return mixed
     */
    public function getData(
        string $query, 
        array $params = []
    );

    /**
     * @param string $query
     * @param array $params
     * @return mixed
     */
    public function getAllData(
        string $query, 
        array $params = []
    );

    /**
     * @param string $query
     * @param array $params
     * @return mixed
     */
    public function setData(
        string $query, 
        array $params = []
    );
}
