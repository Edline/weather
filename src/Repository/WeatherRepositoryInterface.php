<?php

namespace App\Repository;

use App\DTO\WeatherDTO;

/**
 * Interface WeatherRepositoryInterface
 * @package App\Repository
 */
interface WeatherRepositoryInterface
{
    /**
     * @param WeatherDTO $weatherDTO
     */
    public function save(WeatherDTO $weatherDTO): void;

    /**
     * @param array $parameters
     *
     * @return array
     */
    public function findLastThree(array $parameters): array;
}