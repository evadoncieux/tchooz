<?php

namespace App\Controller;

use App\Entity\ClothingItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_user_profile')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $clothingItems = $entityManager->getRepository(ClothingItem::class)->findBy(['user' => $user->getId()]);

        return $this->render('user_profile/index.html.twig', [
            'user' => $user,
            'clothingItems' => $clothingItems,
        ]);
    }
}
