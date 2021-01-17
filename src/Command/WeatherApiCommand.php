<?php

namespace App\Command;

use App\Helper\DateTimeHelper;
use App\Service\Weather;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


/**
 * Class WeatherApiCommand
 * @package App\Command
 */
final class WeatherApiCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:weather-api-save';

    /**
     * @var Weather
     */
    private $weather;

    /**
     * WeatherApiCommand constructor.
     *
     * @param Weather $weather
     */
    public function __construct(Weather $weather)
    {
        parent::__construct(self::$defaultName);

        $this->weather = $weather;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->text(sprintf('Command %s start at: %s', self::$defaultName, DateTimeHelper::getDateTimeNow()));

        $this->weather->save();

        $io->text(sprintf('Command %s stop at: %s', self::$defaultName, DateTimeHelper::getDateTimeNow()));

        return Command::SUCCESS;
    }
}