<?php

namespace App\Controller;

use App\Service\SuggestionGenerator\SuggestionGeneratorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class SuggestionController extends AbstractController
{
    public function __construct(
        private readonly SuggestionGeneratorService $suggestionGeneratorService,
    )
    {
    }

    /**
     * @throws \Exception
     */
    #[Route('/suggestion', name: 'generate_suggestion')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function getSuggestions(): Response
    {
        $suggestions = $this->suggestionGeneratorService->generateSuggestion();

        return $this->render('suggestion/index.html.twig', [
            'suggestions' => $suggestions,
        ]);
    }


}
