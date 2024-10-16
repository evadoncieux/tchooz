<?php

namespace App\Controller\Search;

use App\Repository\ClothingItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

class SearchController extends AbstractController
{
    public function __construct(private readonly ClothingItemRepository $clothingItemRepository,
    private readonly SerializerInterface $serializer)
    {
    }

    #[Route(path: '/clothes/search', name: 'app_search_clothes', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function search(Request $request): JsonResponse
    {
        $searchString = $request->query->get('q');
        $results = $this->clothingItemRepository->searchOutfits($searchString);

        $data = $this->serializer->serialize($results, 'json', [
            'groups' => 'clothing_item',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new JsonResponse($data, 200, [], true);
    }
}
