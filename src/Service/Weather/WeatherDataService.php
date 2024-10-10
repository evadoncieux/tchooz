<?php

namespace App\Service\Weather;

use App\Entity\CurrentWeather;
use App\Entity\User;
use App\Service\Api\WeatherApiService;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

readonly class WeatherDataService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private WeatherApiService      $weatherApiService,
        protected Security             $security,
        private LoggerInterface        $logger,
    )
    {
    }

    public function getWeatherData(string $location): CurrentWeather
    {
        $this->logger->info("Attempting to get weather data for location: {$location}");

        $user = $this->findUser();
        $lastLoggedWeather = $this->getLastLoggedWeather($location, $user);

        if ($this->isWeatherDataValid($lastLoggedWeather)) {
            return $this->fetchAndSaveNewWeatherData($location, $user);
        }

        $this->logger->notice("Using cached weather data for {$location}, last updated {$this->getTimeIntervalSinceLastUpdate($lastLoggedWeather)} seconds ago");
        return $lastLoggedWeather;
    }

    private function findUser(): User
    {
        $user = $this->security->getUser();
        if (!$user instanceof User) {
            throw new \RuntimeException('User not found or not authenticated.');
        }
        return $user;
    }

    private function getLastLoggedWeather(string $location, User $user): ?CurrentWeather
    {
        $cityName = $user->getOpenWeatherCityName() ?? $location;
        return $this->entityManager->getRepository(CurrentWeather::class)
            ->findOneBy(['city' => $cityName], ['timestamp' => 'DESC']);
    }

    private function isWeatherDataValid(?CurrentWeather $weather): bool
    {
        if (!$weather) {
            return true;
        }
        $currentDatetime = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $timeInterval = $currentDatetime->getTimestamp() - $weather->getTimestamp()->getTimestamp();
        return $timeInterval >= 3600;
    }

    private function getTimeIntervalSinceLastUpdate(CurrentWeather $weather): int
    {
        $currentDatetime = new DateTime('now', new DateTimeZone('Europe/Paris'));
        return $currentDatetime->getTimestamp() - $weather->getTimestamp()->getTimestamp();
    }

    private function fetchAndSaveNewWeatherData(string $location, User $user): CurrentWeather
    {
        $this->logger->notice("Fetching new weather data for {$location}");

        try {
            $weatherApiData = $this->weatherApiService->getWeatherData($location);
            $this->logger->debug("Weather API response");
        } catch (Exception $error) {
            $this->logger->error('Weather API error: ' . $error->getMessage(), [
                'exception' => $error,
                'location' => $location
            ]);
            throw new ServiceUnavailableHttpException('Could not fetch data. Please try again later.');
        }

        $weatherData = $this->createWeatherDataFromApiResponse($weatherApiData);
        $user->setOpenWeatherCityName($weatherApiData['name']);

        $this->entityManager->persist($weatherData);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->logger->info("New weather data logged for { $location }");

        return $weatherData;
    }

    private function createWeatherDataFromApiResponse(array $weatherApiData): CurrentWeather
    {
        $weatherData = new CurrentWeather();
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
        $weatherData->setTimestamp(new DateTime('now', new DateTimeZone('Europe/Paris')));

        return $weatherData;
    }
}
