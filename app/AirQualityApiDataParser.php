<?php

namespace App;

class AirQualityApiDataParser
{
    /**
     * @param array $data
     * @param null $index
     *
     * @return array
     *
     * @throws \Exception
     */
    public function parse(array $data, $index = null)
    {
        $requestedIndex = $this->getRequestedIndex($data, $index);
        $requestedValueTypes = explode(',', getenv('REQUESTED_VALUE_TYPES'));
        $filteredSensorData = [];

        $filteredSensorData['timestamp'] = $this->readField($requestedIndex, 'timestamp');
        foreach ($this->readField($requestedIndex, 'sensordatavalues') as $item) {
            $itemValueType = $this->readField($item, 'value_type');
            $itemValue = $this->readField($item, 'value');

            if (in_array($itemValueType, $requestedValueTypes)) {
                $filteredSensorData[$itemValueType] = $itemValue;
            }
        }

        return $filteredSensorData;
    }

    /**
     * @param array $data
     * @param null $index
     *
     * @return mixed|null
     *
     * @throws \Exception
     */
    private function getRequestedIndex(array $data, $index = null)
    {
        $index = (null !== $index) ? $index : getenv('STARTING_INDEX');

        return $this->readField($data, $index);
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
}