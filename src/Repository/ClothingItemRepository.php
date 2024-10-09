<?php

namespace App\Repository;

use App\Entity\ClothingItem;
use App\Service\SuggestionGenerator\SuggestionGeneratorService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ClothingItem>
 */
class ClothingItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private readonly SuggestionGeneratorService $suggestionGeneratorService)
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

    public function findItemByWeatherAndCategory(string $weather,  string $category):array
    {
        $weatherType = $this->suggestionGeneratorService->determineWeatherType($weather);

        return $this->createQueryBuilder('c')// ok
            ->select('c')// ok
            ->where('c.weather = :weather')
            ->andWhere('c.category = :category')// ok
            ->setParameter('weather', $weather)
            ->setParameter('category', $category)// ok
            ->getQuery() // ok
            ->getResult() // ok
            ;
    }

}
