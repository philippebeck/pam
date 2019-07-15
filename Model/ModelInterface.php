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
    public function list(string $value = null, string $key = null);

    /**
     * @param array $data
     */
    public function create(array $data);

    /**
     * @param string $value
     * @param string|null $key
     * @return array|mixed
     */
    public function read(string $value, string $key = null);

    /**
     * @param string $value
     * @param array $data
     * @param string|null $key
     */
    public function update(string $value, array $data, string $key = null);

    /**
     * @param string $value
     * @param string|null $key
     */
    public function delete(string $value, string $key = null);
}

