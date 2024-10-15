<?php

namespace App\Controller\Search;

use App\Repository\ClothingItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SearchController extends AbstractController
{
    public function __construct(private readonly ClothingItemRepository $clothingItemRepository){

    }

    #[Route(path: '/clothes/search/{searchString}', name: 'app_search_clothes')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function search(string $searchString): JsonResponse
    {

        $results = $this->clothingItemRepository->searchOutfit($searchString);

        return $this->json($results);
    }
}
