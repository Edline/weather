<?php

namespace App\Controller\Api\v1;

use App\Service\Weather;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Throwable;

/**
 * Class WeatherController
 * @package App\Controller\Api\v1
 *
 * @Route("/api/v1/weathers", name="weathers")
 */
final class WeatherController
{
    /**
     * @var Weather
     */
    private $weather;
    /**
     * @var NormalizerInterface
     */
    private $normalizer;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(Weather $weather, NormalizerInterface $normalizer, LoggerInterface $logger)
    {
        $this->weather    = $weather;
        $this->normalizer = $normalizer;
        $this->logger     = $logger;
    }

    /**
     * @Route("/city", methods={"GET"})
     */
    public function get()
    {
        try {
            $content = $this->normalizer->normalize($this->weather->findAll());

            if (empty($content)) {
                return new JsonResponse($content, Response::HTTP_NO_CONTENT);
            }

            return new JsonResponse($content, Response::HTTP_OK);
        } catch (Throwable $exception) {
            $this->logger->error($exception);
            
            throw new $exception;
        }
    }
}