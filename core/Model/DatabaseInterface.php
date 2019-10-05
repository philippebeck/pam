<?php

namespace Pam\Model;

/**
 * Interface DatabaseInterface
 * @package Pam\Model
 */
interface DatabaseInterface
{
    /**
     * @param string $query
     * @param array $params
     * @return mixed
     */
    public function getData(string $query, array $params = []);

    /**
     * @param string $query
     * @param array $params
     * @return mixed
     */
    public function getAllData(string $query, array $params = []);

    /**
     * @param string $query
     * @param array $params
     * @return mixed
     */
    public function setData(string $query, array $params = []);
}
