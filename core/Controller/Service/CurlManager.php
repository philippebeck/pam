<?php

namespace Pam\Controller\Service;

/**
 * Class CurlManager
 * @package Pam\Controller\Service
 */
class CurlManager
{
    /**
     * @param string $query
     * @return mixed
     */
    public function getApiData(string $query)
    {
        $curl = curl_init($query);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        $json = curl_exec($curl);

        curl_close($curl);

        return json_decode($json, true);
    }
}
