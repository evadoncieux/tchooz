<?php

namespace App\Service\Api;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class WeatherApiService
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private string $apiKey,
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
    public function fetchWeather(): array
    {
        $location = 'Lyon';
        $apiUrl = 'http://api.weatherapi.com/v1/current.json?key=' . $this->apiKey . '&q=' . $location;

        try {
            return $this->httpClient->request('GET', $apiUrl)->toArray();
        } catch (ClientExceptionInterface|DecodingExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|TransportExceptionInterface $e) {
            dd($e->getMessage()); // pour l'instant je mets un truc sale comme ça et je ferais des pages spéciales laterrrr
        }
    }

}
