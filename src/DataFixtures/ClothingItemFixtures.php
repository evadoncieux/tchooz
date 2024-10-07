<?php

namespace App\DataFixtures;

use App\Entity\ClothingItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class ClothingItemFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(private readonly SluggerInterface $slugger,
                                private readonly WeatherTypeFixtures $weatherTypeFixtures,
                                private readonly CategoryFixtures $categoryFixtures
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $jsonFile = file_get_contents('fixtures/clothing_items.json');
        $clothingItemsData = json_decode($jsonFile, true, 512, JSON_THROW_ON_ERROR);

        $weatherTypes = $this->weatherTypeFixtures->getWeatherTypes();
        $categories = $this->categoryFixtures->getCategories();

        foreach ($clothingItemsData as $itemData) {
            $clothingItem = new ClothingItem();
            $clothingItem->setName($itemData['name'])
                ->setColor($itemData['color'])
                ->setMaterial($itemData['material'])
                ->setOccasions($itemData['occasion'])
                ->setStyle($itemData['style']);

            foreach ($itemData['categories'] as $categoryName) {
                $category = $categories->filter(function ($c) use ($categoryName) {
                    return $c->getName() === $categoryName;
                })->first();

                if ($category) {
                    $clothingItem->addCategory($category);
                }
            }
            foreach ($itemData['weatherType'] as $weatherTypeName) {
                $weatherType = $weatherTypes->filter(function ($wt) use ($weatherTypeName) {
                    return $wt->getName() === $weatherTypeName;
                })->first();

                if ($weatherType) {
                    $clothingItem->addWeatherType($weatherType);
                }
            }

            $manager->persist($clothingItem);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            WeatherTypeFixtures::class,
        ];
    }
}
