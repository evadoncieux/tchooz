<?php

namespace App\Controller\ClothingItem;

use App\Service\OutfitGenerator\OutfitGeneratorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class SuggestionController extends AbstractController
{
    public function __construct(private readonly OutfitGeneratorService $suggestionGeneratorService,
    )
    {
    }

    /**
     * @throws \Exception
     */
    #[Route('/suggestion/generate', name: 'app_generate_suggestion')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function getSuggestion(): Response
    {
        $suggestionData = $this->suggestionGeneratorService->generateSuggestion();

        return $this->render('suggestion/new.html.twig', [
            'weather' => $suggestionData[0],
            'outfit' => $suggestionData[1],
        ]);
    }
}
