<?php

namespace App\Service;

use App\DTO\WeatherDTO;
use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class WeatherApi
 * @package App\Service
 */
final class WeatherApi implements WeatherAPIInterface
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var WeatherValidator
     */
    private $weatherApiValidator;

    /**
     * WeatherApi constructor.
     *
     * @param HttpClientInterface $httpClient
     * @param WeatherValidator $weatherApiValidator
     */
    public function __construct(HttpClientInterface $httpClient, WeatherValidator $weatherApiValidator)
    {
        $this->httpClient          = $httpClient;
        $this->weatherApiValidator = $weatherApiValidator;
    }

    /**
     * @param array $weatherApiParameters
     *
     * @return Generator
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getRealTimeBy(array $weatherApiParameters): Generator
    {
        $this->weatherApiValidator->validateRequireParameter($weatherApiParameters);
        $cities = $weatherApiParameters[WeatherParameter::API_CITIES];

        foreach ($cities as $city) {
            $response = $this->httpClient->request(
                Request::METHOD_GET,
                sprintf(
                    '%s?key=%s&q=%s',
                    $weatherApiParameters[WeatherParameter::API_URL],
                    $weatherApiParameters[WeatherParameter::API_KEY],
                    $city
                )
            );

            $weatherDTO = WeatherDTO::jsonToObject($response->getContent());
            $this->weatherApiValidator->validateDTO($weatherDTO);

            yield $weatherDTO;
        }
    }
}