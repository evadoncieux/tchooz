<?php

namespace App\DataFixtures;

use App\Entity\ClothingItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ClothingItemFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $jsonFile = file_get_contents('fixtures/clothing_items.json');
        $clothingItemsData = json_decode($jsonFile, true, 512, JSON_THROW_ON_ERROR);

        foreach ($clothingItemsData as $itemData) {
            $clothingItem = new ClothingItem();
            $clothingItem->setName($itemData['name'])
                ->setColor($itemData['color'])
                ->setMaterial($itemData['material'])
                ->setOccasions($itemData['occasion'])
                ->setStyle($itemData['style']);

            foreach ($itemData['categories'] as $categoryName) {
                $category = $this->getReference(CategoryFixtures::CATEGORY_REFERENCE_PREFIX . array_search($categoryName, $this->getReference('category_list'), true));
                $clothingItem->addCategory($category);
            }

            foreach ($itemData['weatherType'] as $weatherTypeName) {
                $weatherType = $this->getReference(WeatherTypeFixtures::WEATHER_TYPE_REFERENCE_PREFIX . array_search($weatherTypeName, $this->getReference('weather_type_list'), true));
                $clothingItem->addWeatherType($weatherType);
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
