<?php

namespace App\Service\Data;

use App\Entity\DailyWeather;
use App\Service\Api\WeatherApiService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

readonly class WeatherDataService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private WeatherApiService      $weatherApiService,
        private LoggerInterface        $logger,
    )
    {

    }

    public function getWeather(string $location): DailyWeather
    {
        try {
            $weatherApiData = $this->weatherApiService->getWeatherData($location);
        } catch (Exception $error) {
            $this->logger->error('Weather API error: ' . $error->getMessage());

            throw new ServiceUnavailableHttpException('Could not fetch data. Please try again later.');
        }

        $weatherData = new DailyWeather();
        $weatherData->setHumidity($weatherApiData['current']['humidity'])
            ->setTemperature($weatherApiData['current']['temp_c'])
            ->setWeatherType()
            ->setTimestamp(new DateTime());

        $this->entityManager->persist($weatherData);
        $this->entityManager->flush();

        return $weatherData;
    }

    public function getDailyWeather(): ?DailyWeather
    {
        return $this->entityManager->getRepository(DailyWeather::class)
            ->findOneBy([], ['timestamp' => 'DESC']);
    }
}
