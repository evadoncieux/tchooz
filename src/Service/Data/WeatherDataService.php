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
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

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
        $coordinates = $this->locationApiService->getCoordinates($location);
        $cityName = $coordinates[0]['name'];
        $lastLoggedWeather = $this->entityManager->getRepository(DailyWeather::class)
            ->findOneBy(['city' => $cityName], ['timestamp' => 'DESC']);

        if (!$lastLoggedWeather || new DateTime('-1h', new DateTimeZone('Europe/Paris')) > $lastLoggedWeather['timestamp']) {
            try {
                $weatherApiData = $this->weatherApiService->getWeatherData($location);
            } catch (Exception $error) {
                $this->logger->error('Weather API error: ' . $error->getMessage());

                throw new ServiceUnavailableHttpException('Could not fetch data. Please try again later.');
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
            $weatherData
                ->setTimestamp(new DateTime('now', new DateTimeZone('Europe/Paris')));

            $this->entityManager->persist($weatherData);
            $this->entityManager->flush();
        } else {
            $weatherData = $lastLoggedWeather;
        }

        return $weatherData;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws \JsonException
     */
    public function getDailyWeather(string $location): ?DailyWeather
    {
        $coordinates = $this->locationApiService->getCoordinates($location);
        $cityName = $coordinates[0]['name'];
        return $this->entityManager->getRepository(DailyWeather::class)
            ->findOneBy(['city' => $cityName], ['timestamp' => 'DESC']);
    }
}
