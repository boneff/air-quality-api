<?php

if (php_sapi_name() !== 'cli') {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

use App\APIClient;
use App\AirQualityApiDataParser;

// load config
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$sensorId = isset($argv[2]) && is_int($argv[2]) ? $argv[2] : getenv('API_SENSOR_DEFAULT_ID');
$requestUrl = getenv('API_BASE_URL').getenv('API_SENSOR_ENDPOINT').$sensorId.DIRECTORY_SEPARATOR;

$client = new APIClient($requestUrl);
$data = $client->call();

$dataParser = new AirQualityApiDataParser();
$formattedData = $dataParser->parse($data);

$message  = '';
foreach ($formattedData as $key => $value) {
    $message .= $key.": ".$value." ";
}

fwrite(STDOUT, $message);
