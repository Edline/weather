<?php

namespace App\Repository;

use App\DTO\WeatherDTO;
use App\Service\WeatherParameter;
use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception as DBALDriverException;
use Doctrine\DBAL\Exception;

/**
 * Class WeatherRepository
 * @package App\Repository
 */
class WeatherRepository implements WeatherRepositoryInterface
{
    /**
     *
     */
    private const TABLE_NAME = 'weather';
    /**
     *
     */
    private const TABLE_GET_LIMIT = 3;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * WeatherRepository constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param WeatherDTO $weatherDTO
     *
     * @throws Exception
     */
    public function save(WeatherDTO $weatherDTO): void
    {
        $qb = $this->connection->createQueryBuilder();

        $qb->insert(self::TABLE_NAME)
           ->setValue('uuid', ':uuid')
           ->setValue('city', ':city')
           ->setValue('temperature', ':temperature')
           ->setValue('created_at', ':created_at')
           ->setParameter('uuid', uniqid('', true))
           ->setParameter('city', $weatherDTO->getCity())
           ->setParameter('temperature', $weatherDTO->getTemperature())
           ->setParameter('created_at', (new DateTime())->getTimestamp());

        $qb->execute();
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws DBALDriverException
     * @throws Exception
     */
    public function findLastThree(array $parameters): array
    {
        $result = [];
        $cities = $parameters[WeatherParameter::API_CITIES];

        foreach ($cities as $city) {
            $stmt = $this->connection->prepare(
                sprintf("select * from %s Where city= :city order by created_at DESC LIMIT %d ", self::TABLE_NAME, self::TABLE_GET_LIMIT)
            );
            $stmt->execute(['city' => $city,]);

            if (!empty($fetchAllAssociative = $stmt->fetchAllAssociative())) {
                $result[] = $fetchAllAssociative;
            }
        }

        return $result;
    }
}
