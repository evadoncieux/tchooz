<?php

namespace App\Controller\Outfit;

use App\Entity\Outfit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


/**
 * Display the current user's outfits
 */
class OutfitController extends AbstractController
{
    public function __construct(
    )
    {
    }

    /**
     * display all of the current user's outfits
     *
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/outfit', name: 'app_outfit_index')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $outfits = $entityManager->getRepository(Outfit::class)->findBy(['user' => $this->getUser()]);

        return $this->render('outfit/index.html.twig', [
            'outfits' => $outfits,
        ]);
    }
}
