<?php

namespace App;


class AirQualityApiService
{
    /**
     * @var ApiClient
     */
    private $client;
    /**
     * @var AirQualityApiDataParser
     */
    private $parser;

    public function __construct(AirQualityApiDataParser $parser, ApiClient $client)
    {
        $this->client = $client;
        $this->parser = $parser;
    }

    /**
     * @param $argv
     *
     * @return string
     *
     * @throws \Exception
     */
    public function getSensorData($argv)
    {
        $data = $this->client->call($this->buildRequestUrl($argv));

        $this->parser->parseRequestedFields($data, ['timestamp', 'sensordatavalues']);

        return $this->parser->__toString();
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