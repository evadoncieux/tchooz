<?php

namespace App\Controller;

use App\Service\Weather\WeatherDataService;
use App\Service\Weather\WeatherParametersService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{

    public function __construct(
        private readonly WeatherDataService       $weatherDataService,
        private readonly WeatherParametersService $weatherParametersService,
    )
    {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $user = $this->getUser();

        if ($user) {
            $userLocation = $user->getLocation();
            $weatherData = $this->weatherDataService->getWeatherData($userLocation);
            $weatherString = $this->weatherParametersService->getWeather($userLocation);

        return $this->render('home/index.html.twig', [
            'weatherData' => $weatherData,
            'weatherString' => $weatherString,
            'user_location' => $userLocation,
        ]);
        }

        return $this->render('home/index.html.twig', []);
    }
}
