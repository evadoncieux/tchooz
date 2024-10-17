<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * gets autocomplete for the city input
 */
class CityAutocompleteController extends AbstractController
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string              $apiKey,
    ) {
    }

    #[Route('/api/city-autocomplete', name: 'api_city_autocomplete', methods: ['GET'])]
    public function autocomplete(Request $request): JsonResponse
    {
        $query = $request->query->get('query');

        if (empty($query) || strlen($query) < 2) {
            return new JsonResponse(['error' => 'Query too short'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $response = $this->httpClient->request(
                'GET',
                'https://api.api-ninjas.com/v1/city',
                [
                    'headers' => [
                        'X-Api-Key' => $this->apiKey,
                    ],
                    'query' => [
                        'name' => $query,
                        'limit' => 10, // Limit the number of results
                    ],
                ]
            );

            $cities = $response->toArray();

            // Simplify the response structure
            $simplifiedCities = array_map(static function($city) {
                return [
                    'name' => $city['name'],
                    'country' => $city['country'],
                ];
            }, $cities);

            return $this->json($simplifiedCities);
        } catch (TransportExceptionInterface $e) {
            return new JsonResponse(['error' => 'Failed to fetch city data'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
