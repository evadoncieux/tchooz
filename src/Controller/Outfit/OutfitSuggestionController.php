<?php

namespace App\Controller\Outfit;

use App\Service\OutfitGenerator\OutfitGeneratorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class OutfitSuggestionController extends AbstractController
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
        $outfit = $suggestionData[1];
        $message = '';

        if ($outfit === null) {
            $message = 'Sorry we could not generate a new outfit suggestion, try again later';
        }

        return $this->render('suggestion/generate.html.twig', [
            'weather' => $suggestionData[0],
            'outfit' => $suggestionData[1],
            'message' => $message,
        ]);
    }
}
