<?php

namespace App\DataFixtures;

use App\Entity\WeatherType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class WeatherTypeFixtures extends Fixture implements OrderedFixtureInterface
{
    public const WEATHER_TYPE_REFERENCE_PREFIX = 'weather_type_';

    private array $weatherTypes = ['Sunny', 'Rainy', 'Snowy', 'Windy', 'Cold', 'Hot'];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->weatherTypes as $index => $weatherTypeName) {
            $weatherType = new WeatherType();
            $weatherType->setName($weatherTypeName);

            $manager->persist($weatherType);

            $this->addReference(self::WEATHER_TYPE_REFERENCE_PREFIX . $index, $weatherType);
        }

        $this->addReference('weather_type_list', (object)$this->weatherTypes);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 2;
    }

}
