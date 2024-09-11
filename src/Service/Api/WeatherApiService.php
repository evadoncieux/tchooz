<?php

namespace App\Service\Api;

use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
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
        private string              $apiKey,
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws \JsonException
     */
    public function getWeatherData(string $location = 'Lyon'): array
    {
        try {
            return $this->httpClient->request('GET', $this->buildApiUrl($location))->toArray();
        } catch (Exception $error) {
            $this->logger->error('Weather API error: ' . $error->getMessage());

            throw new ServiceUnavailableHttpException('Weather service is currently unavailable. Please try again later.');
        }
    }

    private function buildApiUrl(string $location): string
    {
        $baseUrl = 'http://api.weatherapi.com/v1/current.json';
        $queryParams = http_build_query([
            'key' => $this->apiKey,
            'q' => $location,
        ]);

        return $baseUrl . '?' . $queryParams;
    }

}
