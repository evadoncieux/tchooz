<?php

namespace App\Controller\User;

use App\Entity\Outfit;
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
        $username = $user->getUsername();
        $outfits = $entityManager->getRepository(Outfit::class)->findAll();

        return $this->render('user_profile/index.html.twig', [
            'user' => $user,
            'username' => $username,
            'outfits' => $outfits,
        ]);
    }
}
