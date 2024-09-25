<?php

namespace App\DataFixtures;

use App\Entity\ClothingItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClothingItemFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $jsonData = file_get_contents( 'fixtures/clothing_items.json');
        $items = json_decode($jsonData, true, 512, JSON_THROW_ON_ERROR);

        foreach ($items as $itemData) {
            $item = new ClothingItem();
            $item->setName($itemData['name']);
            $item->setColor($itemData['color']);
            $item->setCategory($itemData['category']);
            $item->setWeatherType($itemData['weatherType']);
            $item->setMaterial($itemData['material']);
            $item->setStyle($itemData['style']);
            $item->setOccasion($itemData['occasion']);
            $item->setSeason($itemData['season']);

            $manager->persist($item);
        }

        $manager->flush();
    }
}
