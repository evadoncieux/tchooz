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
    #[Route('/clothes', name: 'app_clothes')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $clothingItems = $entityManager->getRepository(ClothingItem::class)->findBy(['user' => $user->getId()], ['timestamp' =>'DESC']);

        return $this->render('clothing_item/index.html.twig', [
            'clothingItems' => $clothingItems,
        ]);
    }

    #[Route('/clothes/add', name: 'app_clothes_add')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function addClothingItems(Request                $request,
                                     EntityManagerInterface $entityManager,
                                     UrlGeneratorInterface  $urlGenerator): Response
    {
        $user = $this->getUser();
        $clothingItem = new ClothingItem();
        $addClothingItemForm = $this->createForm(AddClothingItemType::class, $clothingItem);
        $addClothingItemForm->handleRequest($request);

        $url = $urlGenerator->generate('app_clothes');

        if ($addClothingItemForm->isSubmitted() && $addClothingItemForm->isValid()) {
            $clothingItem->setUser($user);
            $clothingItem->setTimestamp(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
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
