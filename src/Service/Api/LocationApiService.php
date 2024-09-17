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

    // $cityCode sera à récup dans le profil de l'utilisateur
    // c'est ca qui bugge ? OUI TODO fix ça
    private function buildApiUrl(string $cityCode): string
    {
        $baseUrl = 'http://api.openweathermap.org/geo/1.0/direct';
        $queryParams = http_build_query([
            'q' => $cityCode, // y'a un pb lors du passage de la location à l'api, on a ça dans la requete
            'limit' => 3,
            'appid' => $this->apiKey,
        ]);

        $apiUrl = $baseUrl . '?' . $queryParams;

        /*var_dump($apiUrl);*/

        return $apiUrl;
    }
}

// TODO this means that we have to use an api or stg to fetch city names across the globe
