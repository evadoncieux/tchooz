<?php

namespace App\Controller;

use App\Service\Api\WeatherApiService;
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
        private readonly WeatherApiService $weatherApiService,
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
        $weatherData = $this->weatherApiService->fetchWeather();

        return $this->render('daily_weather/index.html.twig', [
            'weatherData' => $weatherData,
        ]);
    }
}
