<?php

namespace App;

class APIClient
{
    private $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return array|bool
     */
    public function call()
    {
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $this->url);
        // Set the result output to be a string.
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($handle);
        curl_close($handle);

        return json_decode($data, JSON_OBJECT_AS_ARRAY);;
    }
}
