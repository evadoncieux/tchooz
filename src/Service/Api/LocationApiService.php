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

/** TODO AJOUTE DE LA DOC EVA  */
/**
 * @method render(string $string, \Exception[] $array)
 */
readonly class LocationApiService
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
    public function getCoordinates(string $cityCode): array
    {
        try {
            return $this->httpClient->request('GET', $this->buildApiUrl($cityCode))->toArray();
        } catch (Exception $error) {
            $this->logger->error('Geocoding API error: ' . $error->getMessage());

            throw new ServiceUnavailableHttpException('Geocoding service is currently unavailable. Please try again later.');
        }
    }

    private function buildApiUrl(string $cityCode): string
    {
        $baseUrl = 'http://api.openweathermap.org/geo/1.0/direct';
        $queryParams = http_build_query([
            'q' => $cityCode,
            'limit' => 3,
            'appid' => $this->apiKey,
        ]);

        return $baseUrl . '?' . $queryParams;
    }
}
