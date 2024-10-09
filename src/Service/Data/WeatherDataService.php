<?php

namespace App\Service\Data;

use App\Entity\DailyWeather;
use App\Service\Api\LocationApiService;
use App\Service\Api\WeatherApiService;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

readonly class WeatherDataService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private WeatherApiService      $weatherApiService,
        private LocationApiService     $locationApiService,
        private LoggerInterface        $logger,
    )
    {
    }

    public function logWeather(string $location): DailyWeather
    {
        $this->logger->info("Attempting to log weather for location: { $location }");

        $lastLoggedWeather = $this->getWeather($location);
        $currentDatetime = new DateTime('now', new DateTimeZone('Europe/Paris'));

        if ($lastLoggedWeather) {
            $timeInterval = $currentDatetime->getTimestamp() - $lastLoggedWeather->getTimestamp();

            if ($timeInterval < 3600) {
                $this->logger->info("Using cached weather data for { $location }, last updated { $timeInterval } seconds ago");
                return $lastLoggedWeather;
            }
        } else {
            $this->logger->info("Fetching new weather data for {$location}");

            try {
                $weatherApiData = $this->weatherApiService->getWeatherData($location);
                $this->logger->debug("Weather API response", ['data' => $weatherApiData]);
            } catch (Exception $error) {
                $this->logger->error('Weather API error: ' . $error->getMessage(), [
                    'exception' => $error,
                    'location' => $location
                ]);
                throw new ServiceUnavailableHttpException('Could not fetch data. Please try again later.');
            }
        }

        $weatherData = new DailyWeather();
        $weatherData
            ->setName($weatherApiData['weather'][0]['main'])
            ->setTemperature($weatherApiData['main']['temp'])
            ->setDescription($weatherApiData['weather'][0]['description'])
            ->setWindSpeed($weatherApiData['wind']['speed'])
            ->setCity($weatherApiData['name'])
            ->setTempFeels($weatherApiData['main']['feels_like'])
            ->setTempMin($weatherApiData['main']['temp_min'])
            ->setTempMax($weatherApiData['main']['temp_max'])
            ->setHumidity($weatherApiData['main']['humidity']);
        if (isset($weatherApiData['rain'])) {
            $weatherData->setRain($weatherApiData['rain']['1h']);
        }
        $weatherData->setTimestamp($currentDatetime);

        $this->entityManager->persist($weatherData);
        $this->entityManager->flush();

        $this->logger->info("New weather data logged for { $location }");


        return $weatherData;
    }

    public function getWeather(string $location): ?DailyWeather
    {
        $this->logger->info("Retrieving last logged weather for { $location }");

        $coordinates = $this->locationApiService->getCoordinates($location);
        $cityName = $coordinates[0]['name'];
        $lastWeather = $this->entityManager->getRepository(DailyWeather::class)
            ->findOneBy(['city' => $cityName], ['timestamp' => 'DESC']);
        if ($lastWeather) {
            $this->logger->info("Found last logged weather for {$cityName}");
        } else {
            $this->logger->info("No previous weather data found for {$cityName}");
        }

        return $lastWeather;
    }
}
