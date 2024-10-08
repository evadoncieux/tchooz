<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\Data\WeatherDataService;
use App\Service\WeatherTypeService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DailyWeatherController extends AbstractController
{

    public function __construct(
        private readonly WeatherDataService $weatherDataService,
        private readonly WeatherTypeService $weatherTypeService,
    )
    {
    }

    #[Route('/daily_weather', name: 'app_daily_weather')]
    public function index(): Response|\Exception
    {
        $userLocation = $this->getUser()->getLocation();
        $weatherData = $this->weatherDataService->getDailyWeather($userLocation);
        $weatherType = $this->weatherTypeService->getWeatherType($userLocation);

        $user = $this->getUser();

//      If data is older than 1 hour or doesn't exist, fetch new data
        if ($user) {

            if (!$weatherData || $weatherData->getTimestamp() < new DateTime('-1 hour')) {
                /** @var  User $user */
                $weatherData = $this->weatherDataService->logWeather($user->getLocation());
            }
        } else {
            return new \Exception('no user found');
        }

        return $this->render('daily_weather/index.html.twig', [
            'weatherData' => $weatherData,
            'user' => $user,
        ]);
    }

}
