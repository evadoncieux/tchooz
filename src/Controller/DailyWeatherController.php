<?php

namespace App\Controller;

use App\Service\Data\WeatherDataService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class DailyWeatherController extends AbstractController
{

    public function __construct(
        private readonly WeatherDataService $weatherDataService,
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
    #[Route('/daily_weather', name: 'app_daily_weather')]
    public function index(): Response
    {
        $weatherData = $this->weatherDataService->getDailyWeather();

//        // If data is older than 1 hour or doesn't exist, fetch new data
        if (!$weatherData || $weatherData->getTimestamp() < new DateTime('-1 hour')) {
            $weatherData = $this->weatherDataService->getWeather('Lyon, FR');
        }

        return $this->render('daily_weather/index.html.twig', [
            'weatherData' => $weatherData,
        ]);
    }

}
