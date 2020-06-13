<?php

namespace Pam\Controller\Globals;

/**
 * Class PostManager
 * @package Pam\Controller\Globals
 */
class PostManager
{
    /**
     * @var mixed
     */
    private $post = null;

    /**
     * PostManager constructor.
     */
    public function __construct()
    {
        $this->post = filter_input_array(INPUT_POST);
    }

    /**
     * @return mixed
     */
    public function getPostArray()
    {
        return $this->post;
    }

    /**
     * @param string $var
     * @return mixed
     */
    public function getPostVar(string $var)
    {
        return $this->post[$var];
    }
}

