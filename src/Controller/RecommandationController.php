<?php

namespace App\Controller;

use App\Service\ChoiceService\RecommandationGeneratorService;
use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class RecommandationController extends AbstractController
{
    public function __construct(private readonly RecommandationGeneratorService $recommandationGeneratorService,
                                private readonly WeatherService             $weatherService,
    )
    {
    }

    /**
     * @throws \Exception
     */
    #[Route('/recommandation', name: 'generate_recommandation')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function getRecommandations(): Response
    {
        $user = $this->getUser();
        $weather = $this->weatherService->getWeather($user->getLocation());
        $recommandations = $this->recommandationGeneratorService->generateRecommandation();

        return $this->render('recommandations/index.html.twig', [
            'recommandations' => $recommandations,
        ]);
    }


}
