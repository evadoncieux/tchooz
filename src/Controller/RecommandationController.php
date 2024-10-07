<?php

namespace App\Controller;

use App\Service\ChoiceService\RecommandationGeneratorService;
use App\Service\WeatherTypeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class RecommandationController extends AbstractController
{
    public function __construct(private readonly RecommandationGeneratorService $recommandationGeneratorService,
                                private readonly WeatherTypeService             $weatherTypeService,
    )
    {
    }

    /**
     * @throws \Exception
     */
    #[Route('/recommandation', name: 'generate_recommandation')]
    public function getRecommandations(): Response
    {
        $user = $this->getUser();
        $weatherType = $this->weatherTypeService->getWeatherType($user->getLocation());
        $recommandations = $this->recommandationGeneratorService->generateRecommandation();

        return $this->render('recommandations/index.html.twig', [
            'recommandations' => $recommandations,
        ]);
    }


}
