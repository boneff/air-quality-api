<?php

if (php_sapi_name() !== 'cli') {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

use App\ApiClient;
use App\AirQualityApiDataParser;
use App\AirQualityApiService;

// load config
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiService = new AirQualityApiService(new AirQualityApiDataParser(), new ApiClient());

fwrite(STDOUT, $apiService->getSensorData($argv)."\n");
