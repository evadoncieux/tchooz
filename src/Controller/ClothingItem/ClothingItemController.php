<?php

namespace App\Controller\ClothingItem;

use App\Entity\ClothingItem;
use App\Exception\NotFoundException;
use App\Form\ClothingItem\ClothingItemType;
use App\Service\File\FileUploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

class ClothingItemController extends AbstractController
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly PaginatorInterface     $paginator,
        private readonly UrlGeneratorInterface  $urlGenerator,
        private readonly FileUploaderService    $fileUploaderService,
        private readonly SluggerInterface       $slugger,
    )
    {
    }

    #[Route('/clothes', name: 'app_clothes')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        $query = $this->entityManager->getRepository(ClothingItem::class)->findByUser($user);
        $clothingItemsPaginated = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            8
        );
        return $this->render('clothing_item/index.html.twig', [
            'clothingItems' => $clothingItemsPaginated,
        ]);
    }

    #[Route('/clothes/details/{slug}', name: 'app_clothes_details')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function details(string $slug): Response
    {
        $user = $this->getUser();
        $clothingItem = $this->entityManager->getRepository(ClothingItem::class)->findOneBy(['slug' => $slug]);
        if (!$clothingItem) {
            throw new NotFoundException('The item' . $slug . 'does not exist');
        }

        return $this->render('clothing_item/details.html.twig', [
            'clothingItem' => $clothingItem,
        ]);
    }

    #[Route('/clothes/add', name: 'app_clothes_add')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function addClothingItems(Request $request): Response
    {
        $user = $this->getUser();
        $clothingItem = new ClothingItem();
        $addClothingItemForm = $this->createForm(ClothingItemType::class, $clothingItem);
        $addClothingItemForm->handleRequest($request);

        $url = $this->urlGenerator->generate('app_clothes');

        if ($addClothingItemForm->isSubmitted() && $addClothingItemForm->isValid()) {
            $clothingItem->setUser($user);
            $clothingItem->setSlug((strtolower($this->slugger->slug($clothingItem->getName()))));
            $clothingItem->setTimestamp(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
            $clothingItemImage = $addClothingItemForm->get('image')->getData();
            if ($clothingItemImage) {
                $filename = $this->fileUploaderService->upload($clothingItemImage, 'clothing_item', strtolower($this->slugger->slug($clothingItem->getName())));
                $clothingItem->setImage($filename);
            }

            $this->entityManager->persist($clothingItem);
            $this->entityManager->flush();
            $this->addFlash('notice', 'Item ' . $clothingItem . ' successfully added');

            return $this->redirect($url);
        }

        return $this->render('clothing_item/form.html.twig', [
            'user' => $user,
            'clothingItemForm' => $addClothingItemForm,
        ]);
    }

    #[Route('/clothes/edit/{slug}', name: 'app_clothes_edit')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function editClothingItems(Request $request,
                                      string  $slug): Response
    {
        $user = $this->getUser();
        $clothingItem = $this->entityManager->getRepository(ClothingItem::class)->findOneBy(['slug' => $slug]);

        $editClothingItemForm = $this->createForm(ClothingItemType::class, $clothingItem);
        $editClothingItemForm->handleRequest($request);

        $url = $this->urlGenerator->generate('app_clothes');

        if ($clothingItem) {
            if ($editClothingItemForm->isSubmitted() && $editClothingItemForm->isValid()) {
                $clothingItem->setUser($user);
                $clothingItem->setSlug((strtolower($this->slugger->slug($clothingItem->getName()))));
                $clothingItem->setTimestamp(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
                $clothingItemImage = $editClothingItemForm->get('image')->getData();
                if ($clothingItemImage) {
                    $filename = $this->fileUploaderService->upload($clothingItemImage, 'clothing_item', strtolower($this->slugger->slug($clothingItem->getName())));
                    $clothingItem->setImage($filename);
                }

                $this->entityManager->persist($clothingItem);
                $this->entityManager->flush();
                $this->addFlash('notice', 'Item ' . $clothingItem . ' successfully edited');

                return $this->redirect($url);
            }
            return $this->render('clothing_item/form.html.twig', [
                'user' => $user,
                'clothingItem' => $clothingItem,
                'clothingItemForm' => $editClothingItemForm,
            ]);
        }
        $this->addFlash('notice', 'Item ' . $clothingItem . ' does not exist');
        return $this->render('clothing_item/index.html.twig');
    }

    #[Route('/clothes/delete/{slug}', name: 'app_clothes_delete')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function deleteClothingItem(string $slug): Response
    {
        $clothingItem = $this->entityManager->getRepository(ClothingItem::class)->findOneBy(['slug' => $slug]);

        $this->entityManager->remove($clothingItem);
        $this->entityManager->flush();

        $this->addFlash('notice', "Item ' . $clothingItem . ' successfully deleted");

        return $this->redirectToRoute('app_clothes');

    }
}
