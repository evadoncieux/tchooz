<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture implements OrderedFixtureInterface
{
    public const CATEGORY_REFERENCE_PREFIX = 'category_';

    private Collection $categories;

    public function __construct(private readonly SluggerInterface $slugger)
    {
        $this->categories = new ArrayCollection();

    }

    public function load(ObjectManager $manager): void
    {
        $categoriesNames = ['tops', 'bottoms', 'dresses', 'outerwear', 'accessories'];

        foreach ($categoriesNames as $categoriesName) {
            $category = new Category();
            $category->setName($categoriesName);

            $manager->persist($category);
            $this->categories->add($category);

            $reference = $this->slugger->slug(strtolower($categoriesName));
            $this->addReference(self::CATEGORY_REFERENCE_PREFIX . $reference, $category);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 3;
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }
}
