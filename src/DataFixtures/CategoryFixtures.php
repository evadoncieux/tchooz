<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture implements OrderedFixtureInterface
{
    public const CATEGORY_REFERENCE_PREFIX = 'category_';

    private array $categories = ['Tops', 'Bottoms', 'Dresses', 'Outerwear', 'Accessories'];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->categories as $index => $categoryName) {
            $category = new Category();
            $category->setName($categoryName);

            $manager->persist($category);

            $this->addReference(self::CATEGORY_REFERENCE_PREFIX . $index, $category);
        }

        $this->addReference('category_list', (object)$this->categories);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 3;
    }
}
