<?php

namespace App\Command;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class MigrateCommand
 * @package App\Command
 */
final class MigrateCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:weather-migrate';

    /**
     * @var Connection
     */
    private $connection;

    /**
     * MigrateCommand constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        parent::__construct(self::$defaultName);

        $this->connection = $connection;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('start');

        $fromSchema = $this->connection->getSchemaManager()->createSchema();
        $toSchema   = clone $fromSchema;

        $newTable = $toSchema->createTable('weather');

        $newTable->addColumn('uuid', 'string', ['notnull' => true]);
        $newTable->addColumn('city', 'string', ['notnull' => true]);
        $newTable->addColumn('temperature', 'string', ['notnull' => true]);
        $newTable->addColumn('created_at', 'integer', ['unsigned' => true]);

        $newTable->setPrimaryKey(['uuid']);

        $sqlArray = $fromSchema->getMigrateToSql($toSchema, $this->connection->getDatabasePlatform());
        foreach ($sqlArray as $sql) {
            $this->connection->executeStatement($sql);
        }

        $io->success('Command success!');

        return Command::SUCCESS;
    }
}