<?php

namespace Pam\Model;

/**
 * Interface ModelInterface
 * @package Pam\Model
 */
interface ModelInterface
{
    /**
     * @param string|null $value
     * @param string|null $key
     * @return array|mixed
     */
    public function listData(
        string $value = null, 
        string $key = null
    );

    /**
     * @param array $data
     */
    public function createData(
        array $data
    );

    /**
     * @param string $value
     * @param string|null $key
     * @return array|mixed
     */
    public function readData(
        string $value, 
        string $key = null
    );

    /**
     * @param string $value
     * @param array $data
     * @param string|null $key
     */
    public function updateData(
        string $value, 
        array $data, 
        string $key = null
    );

    /**
     * @param string $value
     * @param string|null $key
     */
    public function deleteData(
        string $value, 
        string $key = null
    );
}
