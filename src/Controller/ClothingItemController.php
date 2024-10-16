<?php

namespace App\Controller;

use App\Entity\ClothingItem;
use App\Form\ClothingItem\AddClothingItemType;
use App\Form\ClothingItem\EditClothingItemType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

class ClothingItemController extends AbstractController
{
    #[Route('/clothes', name: 'app_clothes')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $clothingItems = $entityManager->getRepository(ClothingItem::class)->findBy(['user' => $user->getId()], ['timestamp' => 'DESC']);

        return $this->render('clothing_item/index.html.twig', [
            'clothingItems' => $clothingItems,
        ]);
    }

    #[Route('/clothes/details/{slug}', name: 'app_clothes_details')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function details(EntityManagerInterface $entityManager,
                            string                 $slug): Response
    {
        $user = $this->getUser();
        $clothingItem = $entityManager->getRepository(ClothingItem::class)->findOneBy(['slug' => $slug]);

        return $this->render('clothing_item/details.html.twig', [
            'clothingItem' => $clothingItem,
        ]);
    }

    #[Route('/clothes/add', name: 'app_clothes_add')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function addClothingItems(Request                $request,
                                     EntityManagerInterface $entityManager,
                                     SluggerInterface       $slugger,
                                     UrlGeneratorInterface  $urlGenerator): Response
    {
        $user = $this->getUser();
        $clothingItem = new ClothingItem();
        $addClothingItemForm = $this->createForm(AddClothingItemType::class, $clothingItem);
        $addClothingItemForm->handleRequest($request);

        $url = $urlGenerator->generate('app_clothes');

        if ($addClothingItemForm->isSubmitted() && $addClothingItemForm->isValid()) {
            $clothingItem->setUser($user);
            $clothingItem->setSlug((strtolower($slugger->slug($clothingItem->getName()))));
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

    #[Route('/clothes/edit/{slug}', name: 'app_clothes_edit')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function editClothingItems(Request                $request,
                                      EntityManagerInterface $entityManager,
                                      UrlGeneratorInterface  $urlGenerator,
                                      string                 $slug): Response
    {
        $user = $this->getUser();
        $clothingItem = $entityManager->getRepository(ClothingItem::class)->findOneBy(['slug' => $slug]);

        $editClothingItemForm = $this->createForm(EditClothingItemType::class, $clothingItem);
        $editClothingItemForm->handleRequest($request);

        $url = $urlGenerator->generate('app_clothes');

        if ($editClothingItemForm->isSubmitted() && $editClothingItemForm->isValid()) {
            $clothingItem->setUser($user);
            $clothingItem->setTimestamp(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
            $entityManager->persist($clothingItem);
            $entityManager->flush();

            return $this->redirect($url);
        }

        return $this->render('clothing_item/edit.html.twig', [
            'user' => $user,
            'clothingitem' => $clothingItem,
            'clothingItemForm' => $editClothingItemForm,
        ]);
    }

    #[Route('/clothes/delete/{slug}', name: 'app_clothes_delete')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function deleteClothingItem(Request                $request,
                                       EntityManagerInterface $entityManager,
                                       string                 $slug): Response
    {
        $clothingItem = $entityManager->getRepository(ClothingItem::class)->findOneBy(['slug' => $slug]);

        $entityManager->remove($clothingItem);
        $entityManager->flush();

        $this->addFlash('success', "The clothing item $clothingItem has been deleted");

        return $this->redirectToRoute('app_clothes');

    }
}
