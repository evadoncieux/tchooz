<?php

namespace App\Repository;

use App\Entity\ClothingItem;
use App\Service\OutfitGenerator\OutfitGeneratorService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ClothingItem>
 */
class ClothingItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private readonly OutfitGeneratorService $suggestionGeneratorService)
    {
        parent::__construct($registry, ClothingItem::class);
    }

    /**
     * @return ClothingItem[] Returns an array of ClothingItem objects
     */
    public function findByCategory($category): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $category)
            ->orderBy('c.categories', 'ASC')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult();
    }

    public function findItemByWeatherAndCategory(string $weather, string $category): array
    {
        $weatherType = $this->suggestionGeneratorService->determineWeatherType($weather);

        return $this->createQueryBuilder('ci')
            ->select('ci')
            ->where('ci.weather = :weather')
            ->andWhere('ci.category = :category')
            ->setParameter('weather', $weather)
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }

    public function searchOutfit(string $searchString): array
    {
        return $this->createQueryBuilder('ci')
            ->select('ci')
            ->where('ci.name LIKE :search')
//            ->orWhere('ci.category LIKE :search')
//            ->orWhere('ci.weather LIKE :search')
//            ->orWhere('ci.material LIKE :search')
//            ->orWhere('ci.colors LIKE :search')
//            ->orWhere('ci.styles LIKE :search')
            ->setParameter('search', '%' . $searchString . '%')
            ->getQuery()
            ->getResult()
            ;
    }


}
