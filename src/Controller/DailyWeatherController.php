<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\Data\WeatherDataService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DailyWeatherController extends AbstractController
{

    public function __construct(
        private readonly WeatherDataService $weatherDataService,
    )
    {
    }

    #[Route('/weather', name: 'app_weather')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(): Response|\Exception
    {
        $user = $this->getUser();

//      If data is older than 1 hour or doesn't exist, fetch new data
        if ($user) {
            $userLocation = $user->getLocation();
            $weatherData = $this->weatherDataService->getDailyWeather($userLocation);

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
