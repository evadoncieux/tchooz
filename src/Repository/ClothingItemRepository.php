<?php

namespace App\Repository;

use App\Entity\ClothingItem;
use App\Entity\User;
use App\Service\OutfitGenerator\OutfitGeneratorService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
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

    public function findByUser(User $user): Query
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.user = :val')
            ->setParameter('val', $user)
            ->orderBy('c.timestamp', 'DESC')
            ->setMaxResults(50)
            ->getQuery();
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

    public function searchOutfits(string $searchString): array
    {
        $entityManager = $this->getEntityManager();

        $sql = '
        SELECT *
        FROM clothing_item ci
        WHERE ci.name LIKE :search
        OR ci.category LIKE :search
        OR ci.weather LIKE :search
        OR ci.material LIKE :search
        OR JSON_CONTAINS(
        LOWER(JSON_UNQUOTE(ci.colors)),
        LOWER(:searchJson),
        "$"
    )
    OR JSON_CONTAINS(
        LOWER(JSON_UNQUOTE(ci.styles)),
        LOWER(:searchJson),
        "$"
    )
    ';

        $rsm = new ResultSetMappingBuilder($entityManager);
        $rsm->addRootEntityFromClassMetadata(ClothingItem::class, 'ci');

        $query = $entityManager->createNativeQuery($sql, $rsm);
        $query->setParameter('search', '%' . $searchString . '%');
        $query->setParameter('searchJson', json_encode($searchString));

        return $query->getResult();
    }


}
