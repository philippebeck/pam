<?php

namespace Pam\Controller\Service;

/**
 * Class CurlManager
 * @package Pam\Controller\Service
 */
class CurlManager
{
    /**
     * @param string $url
     * @param string $query
     * @param string $key
     * @return mixed
     */
    public function getApiData(string $url, string $query, string $key = NASA_API)
    {
        $curl = curl_init("https://" . $url . "?" . $query . "&api_key=" . $key);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        $data = curl_exec($curl);
        curl_close($curl);

        return json_decode($data, true);
    }
}
