<?php

namespace App\Controller;

use App\Service\Weather\WeatherDataService;
use App\Service\Weather\WeatherParametersService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CurrentWeatherController extends AbstractController
{

    public function __construct(
        private readonly WeatherDataService       $weatherDataService,
        private readonly WeatherParametersService $weatherParametersService,
    )
    {
    }

    #[Route('/weather', name: 'app_weather')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(): Response|\Exception
    {
        $user = $this->getUser();

        if ($user) {
            $userLocation = $user->getLocation();
            $weatherData = $this->weatherDataService->getWeatherData($userLocation);
            $weatherString = $this->weatherParametersService->getWeather($userLocation);
        } else {
            return new \Exception('no user found');
        }

        return $this->render('current_weather/index.html.twig', [
            'weatherData' => $weatherData,
            'weatherString' => $weatherString,
            'user_location' => $userLocation,
        ]);
    }

}
