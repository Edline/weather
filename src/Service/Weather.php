<?php

namespace App\Service;

use App\Repository\WeatherRepositoryInterface;
use Psr\Log\LoggerInterface;
use Throwable;

/**
 * Class Weather
 * @package App\Service
 */
final class Weather
{
    /**
     * @var WeatherAPIInterface
     */
    private $weatherAPI;
    /**
     * @var WeatherRepositoryInterface
     */
    private $repository;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var array
     */
    private $parameters;

    /**
     * Weather constructor.
     *
     * @param WeatherAPIInterface $weatherAPI
     * @param WeatherRepositoryInterface $repository
     * @param LoggerInterface $logger
     * @param array $parameters
     */
    public function __construct(WeatherAPIInterface $weatherAPI, WeatherRepositoryInterface $repository, LoggerInterface $logger, array $parameters)
    {
        $this->weatherAPI = $weatherAPI;
        $this->repository = $repository;
        $this->logger     = $logger;
        $this->parameters = $parameters;
    }

    public function save(): void
    {
        try {
            $weathersData = $this->weatherAPI->getRealTimeBy($this->parameters);
            foreach ($weathersData as $city) {
                $this->repository->save($city);
            }
        } catch (Throwable $exception) {
            $this->logger->critical($exception);
        }
    }

    /**
     * @return array
     */
    public function findLastThree(): array
    {
        return $this->repository->findLastThree($this->parameters);
    }
}