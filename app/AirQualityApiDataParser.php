<?php

namespace App;

class AirQualityApiDataParser
{
    private $parsedFields;

    public function __construct()
    {
        $this->parsedFields = [];
    }

    /**
     * @param array $data
     * @param array $requestedFields
     *
     * @return array
     *
     * @throws \Exception
     */
    public function parseRequestedFields(array $data, array $requestedFields = [])
    {
        $requestedData = $this->getRequestedDataByIndex($data);

        foreach ($requestedFields as $fieldName) {
            $this->parsedFields[$fieldName] =
                ('sensordatavalues' === $fieldName)
                    ? $this->parseSensorDataValues($requestedData[$fieldName])
                    : $this->readField($requestedData, $fieldName);
        }

        return $this->parsedFields;
    }

    /**
     * @param array $data
     *
     * @return mixed|null
     *
     * @throws \Exception
     */
    private function getRequestedDataByIndex(array $data)
    {
        return $this->readField($data, getenv('STARTING_INDEX'));
    }

    /**
     * @param array $data
     * @param $fieldName
     *
     * @return mixed
     *
     * @throws \Exception
     */
    private function readField(array $data, $fieldName)
    {
        if (false === isset($data[$fieldName])) {
            throw new \Exception('Tried reading non-existent field: '.$fieldName);
        }
        return $data[$fieldName];
    }

    private function parseSensorDataValues(array $sensorDataValues)
    {
        $fileteredData = [];
        $requestedValueTypes = explode(',', getenv('REQUESTED_VALUE_TYPES'));

        foreach ($sensorDataValues as $item) {
            $itemValueType = $this->readField($item, 'value_type');
            $itemValue = $this->readField($item, 'value');

            if (in_array($itemValueType, $requestedValueTypes)) {
                $fileteredData[$itemValueType] = $itemValue;
            }
        }

        return $fileteredData;
    }
}