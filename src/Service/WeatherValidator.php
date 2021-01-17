<?php

namespace App\Service;

use App\DTO\WeatherDTO;
use App\Exception\ValidateException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class WeatherValidator
 * @package App\Service
 */
final class WeatherValidator
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * WeatherValidator constructor.
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param WeatherDTO $weatherDTO
     */
    public function validateDTO(WeatherDTO $weatherDTO)
    {
        $errors = $this->validator->validate($weatherDTO);
        if (count($errors) > 0) {
            /** @var ConstraintViolation $error */
            foreach ($errors as $error) {
                throw new ValidateException(sprintf('Error! DTO Constraints. Property: %s. Message: %s', $error->getPropertyPath(), $error->getMessage()));
            }
        }
    }

    /**
     * @param array $parameters
     */
    public function validateRequireParameter(array $parameters)
    {
        if (empty($parameters[WeatherParameter::API_KEY])) {
            throw new ValidateException('Error! Weather api key empty');
        }
        if (empty($parameters[WeatherParameter::API_URL]) && WeatherParameter::API_URL !== $parameters[WeatherParameter::API_URL]) {
            throw new ValidateException('Error! Weather api url empty');
        }
        if (empty($parameters[WeatherParameter::API_CITIES])) {
            throw new ValidateException('Error! Weather api cities empty');
        }
    }
}