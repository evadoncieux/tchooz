<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\UserEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserEditController extends AbstractController
{
    #[Route(path: '/settings', name: 'app_user_settings')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function editProfile(Request                $request,
                                EntityManagerInterface $entityManager,
                                UrlGeneratorInterface  $urlGenerator): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw new \RuntimeException('User not found or not authenticated.');
        }
        $userEditForm = $this->createForm(UserEditType::class, $user);
        $userEditForm->handleRequest($request);
        $url = $urlGenerator->generate('app_user_profile');

        if ($userEditForm->isSubmitted() && $userEditForm->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirect($url);
        }

        return $this->render('user_profile/edit.html.twig', [
            'user' => $user,
            'userEditForm' => $userEditForm,
        ]);
    }
}
