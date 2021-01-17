<?php

namespace App\DTO;

use App\Service\WeatherParameter;
use JsonException;
use Symfony\Component\Validator\Constraints as Assert;

use function json_decode;

/**
 * Class WeatherDTO
 * @package App\DTO
 */
final class WeatherDTO
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    private $city;

    /**
     * @var int
     *
     * @Assert\NotBlank()
     */
    private $temperature;

    /**
     * @param string $message
     *
     * @return static
     * @throws JsonException
     */
    public static function jsonToObject(string $message): self
    {
        $message = json_decode($message, true, 512, JSON_THROW_ON_ERROR);

        return (new self())
            ->setCity($message[WeatherParameter::API_LOCATION][WeatherParameter::API_LOCATION_NAME] ?? null)
            ->setTemperature($message[WeatherParameter::API_CURRENT][WeatherParameter::API_CURRENT_TEMP] ?? null);
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     *
     * @return self
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return int
     */
    public function getTemperature(): int
    {
        return $this->temperature;
    }

    /**
     * @param int $temperature
     *
     * @return self
     */
    public function setTemperature(int $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }
}