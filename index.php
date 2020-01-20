<?php

require_once 'app/bootstrap.php';

use App\ApiClient;
use App\AirQualityApiDataParser;
use App\AirQualityApiService;

$apiService = new AirQualityApiService(new AirQualityApiDataParser(), new ApiClient());

fwrite(STDOUT, $apiService->getSensorData($argv)."\n");
