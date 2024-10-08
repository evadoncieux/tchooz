<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClothingItemFixtures extends Fixture
{

    public function __construct(/*private readonly SluggerInterface $slugger,*/
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
//        $jsonFile = file_get_contents('fixtures/clothing_items.json');
//        $clothingItemsData = json_decode($jsonFile, true, 512, JSON_THROW_ON_ERROR);
//
//        foreach ($clothingItemsData as $itemData) {
//            $clothingItem = new ClothingItem();
//            $clothingItem->setName($itemData['name'])
//                ->setColors(array_map([$this, 'mapColor'], $itemData['colors']))
//                ->setMaterial($this->mapMaterial($itemData['material']))
//                ->setStyles(array_map([$this, 'mapStyle'], $itemData['styles']))
//                ->setCategories(array_map([$this, 'mapCategory'], $itemData['categories']))
//                ->setWeatherTypes(array_map([$this, 'mapWeatherType'], $itemData['weather']));
//
//            $manager->persist($clothingItem);
//        }
//
//        $manager->flush();
    }
}
