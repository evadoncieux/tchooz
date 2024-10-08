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
        private LocationApiService  $locationApiService,
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
    public function getWeatherData(string $location): array
    {
        
        try {
            return $this->httpClient->request('GET', $this->buildApiUrl($location))->toArray();
        } catch (Exception $error) {
            $this->logger->error('Weather API error: ' . $error->getMessage());

            throw new \RuntimeException('Weather service is currently unavailable. Please try again later.');
        }
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws \JsonException
     */
    private function buildApiUrl(string $location): string
    {
        /*Coordonnées pour Lyon $lat = '45.75' & $lon = '4.83';*/
        $userLocation = $this->locationApiService->getCoordinates($location);
        $lat = $userLocation[0]['lat'];
        $lon = $userLocation[0]['lon'];

        $baseUrl = 'https://api.openweathermap.org/data/2.5/weather';
        $queryParams = http_build_query([
            'lat' => $lat,
            'lon' => $lon,
            'appid' => $this->apiKey,
            'units' => 'metric',
        ]);

        return $baseUrl . '?' . $queryParams;
    }

}
