<?php

namespace App\Service;

use Generator;

/**
 * Interface WeatherAPIInterface
 * @package App\Service
 */
interface WeatherAPIInterface
{
    /**
     * @param array $weatherApiParameters
     *
     * @return Generator
     */
    public function getRealTimeBy(array $weatherApiParameters): Generator;
}