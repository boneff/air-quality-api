<?php

if (php_sapi_name() !== 'cli') {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

// load config
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$sensorId = isset($argv[2]) && is_int($argv[2]) ? $argv[2] : getenv('API_SENSOR_DEFAULT_ID');

$requestUrl = getenv('API_BASE_URL').getenv('API_SENSOR_ENDPOINT').$sensorId.DIRECTORY_SEPARATOR;

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $requestUrl);
// Set the result output to be a string.
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($handle);
curl_close($handle);

$arrayData = json_decode($data, JSON_OBJECT_AS_ARRAY);

$requestedIndex = $arrayData[getenv('STARTING_INDEX')];
$timestamp = $requestedIndex['timestamp'];
$requestedValueTypes = explode(',', getenv('REQUESTED_VALUE_TYPES'));
$filteredSensorData = [];
foreach ($requestedIndex['sensordatavalues'] as $item) {
    if (in_array($item['value_type'], $requestedValueTypes)) {
        $filteredSensorData[$item['value_type']] = $item['value'];
    }
}

$message  = $timestamp.' ';
foreach ($filteredSensorData as $key => $value) {
    $message .= $key.": ".$value." ";
}


fwrite(STDOUT, $message);
