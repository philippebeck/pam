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
    public function result(string $query, array $params = []);

    /**
     * @param string $query
     * @param array $params
     * @return mixed
     */
    public function results(string $query, array $params = []);

    /**
     * @param string $query
     * @param array $params
     * @return mixed
     */
    public function action(string $query, array $params = []);
}

