<?php

namespace App\DataFixtures;

use App\Entity\ClothingItem;
use App\Enum\ClothingCategory;
use App\Enum\ClothingColor;
use App\Enum\ClothingMaterial;
use App\Enum\ClothingStyle;
use App\Enum\ClothingWeather;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class ClothingItemFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(private readonly SluggerInterface $slugger
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $jsonFile = file_get_contents('fixtures/clothing_items.json');
        $clothingItemsData = json_decode($jsonFile, true, 512, JSON_THROW_ON_ERROR);
        $userPucci = $this->getReference('user_pucci');

        foreach ($clothingItemsData as $itemData) {
            $clothingItem = new ClothingItem();
            $clothingItem
                ->setColors(array_map(static fn($style) => ClothingColor::from($style), $itemData['colors']))
                ->setWeatherTypes(array_map(static fn($style) => ClothingWeather::from($style), $itemData['weather']))
                ->setCategories(array_map(static fn($category) => ClothingCategory::from($category), $itemData['categories']))
                ->setName($itemData['name'])
                ->setMaterial(ClothingMaterial::from($itemData['material']))
                ->setStyles(array_map(static fn($style) => ClothingStyle::from($style), $itemData['styles']))
                ->setUser($userPucci);

            $manager->persist($clothingItem);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AppFixtures::class,
        ];

    }
}
