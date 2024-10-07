<?php

namespace App\Service\Api;

use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @method render(string $string, \Exception[] $array)
 */
readonly class WeatherApiService
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private LoggerInterface     $logger,
        private LocationApiService  $locationService,
        private string              $apiKey,
    )
    {
    }

// TODO faire une interface pour les deux API

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws \JsonException
     */
    public function getWeatherData(string $cityCode): array
    {
        try {
            return $this->httpClient->request('GET', $this->buildApiUrl($cityCode))->toArray();
        } catch (Exception $error) {
            $this->logger->error('Weather API error: ' . $error->getMessage());

            throw new \RuntimeException('Weather service is currently unavailable. Please try again later.');
        }
    }

    private function buildApiUrl(string $cityCode): string
    {
        /*Coordonnées pour Lyon $lat = '45.75' & $lon = '4.83';*/
        $location = $this->locationService->getCoordinates($cityCode);
        $lat = $location[0]['lat'];
        $lon = $location[0]['lon'];

        $baseUrl = 'https://api.openweathermap.org/data/2.5/weather';
        $queryParams = http_build_query([
            'lat' => $lat,
            'lon' => $lon,
            'appid' => $this->apiKey,
            'units' => 'metric',
        ]);

        $apiUrl = $baseUrl . '?' . $queryParams;

//        var_dump($apiUrl);

        return $apiUrl;
    }

}
