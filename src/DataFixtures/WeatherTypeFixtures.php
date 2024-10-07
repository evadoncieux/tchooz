<?php

namespace App\DataFixtures;

use App\Entity\WeatherType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class WeatherTypeFixtures extends Fixture implements OrderedFixtureInterface
{
    public const WEATHER_TYPE_REFERENCE_PREFIX = 'weather_type_';
    private Collection $weatherTypes;
    private ObjectManager $manager;

    public function __construct(private readonly SluggerInterface $slugger)
    {
        $this->weatherTypes = new ArrayCollection();
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $weatherTypeNames = ['Sunny'];

        $existingWeatherTypes = $manager->getRepository(WeatherType::class)->findAll();
        $existingNames = array_map(static fn($wt) => $wt->getName(), $existingWeatherTypes);

        foreach ($weatherTypeNames as $weatherTypeName) {
            if (!in_array($weatherTypeName, $existingNames, true)) {
                $this->createWeatherType($weatherTypeName);
            } else {
                $existingWeatherType = $manager->getRepository(WeatherType::class)->findOneBy(['name' => $weatherTypeName]);
                $this->weatherTypes->add($existingWeatherType);
                $reference = $this->slugger->slug(strtolower($weatherTypeName));
                $this->addReference(self::WEATHER_TYPE_REFERENCE_PREFIX . $reference, $existingWeatherType);
            }
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 2;
    }

    public function getWeatherTypes(): Collection
    {
        return $this->weatherTypes;
    }

    private function createWeatherType(string $name): WeatherType
    {
        $weatherType = new WeatherType();
        $weatherType->setName($name);

        $this->manager->persist($weatherType);
        $this->weatherTypes->add($weatherType);

        $reference = $this->slugger->slug(strtolower($name));
        $this->addReference(self::WEATHER_TYPE_REFERENCE_PREFIX . $reference, $weatherType);

        return $weatherType;
    }
}
