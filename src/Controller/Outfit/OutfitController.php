<?php

namespace App\Controller\Outfit;

use App\Entity\Outfit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class OutfitController extends AbstractController
{
    public function __construct(
    )
    {
    }
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
