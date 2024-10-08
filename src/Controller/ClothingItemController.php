<?php

namespace App\Controller;

use App\Entity\ClothingItem;
use App\Form\AddClothingItemType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ClothingItemController extends AbstractController
{
    #[Route('/clothing/item', name: 'app_clothing_item')]
    public function index(): Response
    {
        return $this->render('clothing_item/index.html.twig', [
            'controller_name' => 'ClothingItemController',
        ]);
    }

    #[Route('/profile/add_clothes', name: 'app_add_clothes')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function addClothingItems(Request                $request,
                                     EntityManagerInterface $entityManager,
                                     UrlGeneratorInterface  $urlGenerator): Response
    {
        $user = $this->getUser();
        $clothingItem = new ClothingItem();
        $addClothingItemForm = $this->createForm(AddClothingItemType::class, $clothingItem);
        $addClothingItemForm->handleRequest($request);

        $url = $urlGenerator->generate('app_user_profile');

        if ($addClothingItemForm->isSubmitted() && $addClothingItemForm->isValid()) {
            $entityManager->persist($clothingItem);
            $entityManager->flush();

            return $this->redirect($url);
        }

        return $this->render('clothing_item/add.html.twig', [
            'user' => $user,
            'clothingItemForm' => $addClothingItemForm,
        ]);
    }
}
