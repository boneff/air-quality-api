<?php

namespace Test;

use App\AirQualityApiDataParser;
use PHPUnit\Framework\TestCase;

class AirQualityApiDataParserTest extends TestCase
{
    public function testParseDataSuccessfully()
    {
        $apiData = json_decode(file_get_contents(__DIR__."/sensor-data-9202.json"), true);

        //explicitly set config values so we do not produce a flaky test
        putenv('API_SENSOR_DEFAULT_ID=9202');
        putenv('STARTING_INDEX=1');
        putenv('REQUESTED_VALUE_TYPES=P1,P2');

        $parser = new AirQualityApiDataParser();

        $expectedData = [
            'timestamp' => '2020-01-20 00:11:09',
            'sensordatavalues' => [
                'P1' => '21.08',
                'P2' => '13.57'
            ]
        ];

        $this->assertEquals($expectedData, $parser->parseRequestedFields($apiData, ['timestamp', 'sensordatavalues']));
    }
}
