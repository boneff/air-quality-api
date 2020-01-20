<?php

namespace App;

class ApiClient
{
    /**
     * @param string $url
     *
     * @return array|bool
     */
    public function call(string $url)
    {
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        // Set the result output to be a string.
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($handle);
        curl_close($handle);

        return json_decode($data, JSON_OBJECT_AS_ARRAY);
    }

    /**
     * @return string
     */
    private function buildRequestUrl($argv)
    {
        $sensorId = isset($argv[2]) && is_int($argv[2]) ? $argv[2] : getenv('API_SENSOR_DEFAULT_ID');
        $requestUrl = getenv('API_BASE_URL').getenv('API_SENSOR_ENDPOINT').$sensorId.DIRECTORY_SEPARATOR;

        return $requestUrl;
    }
}
