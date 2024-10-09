<?php

namespace App\Service\SuggestionGenerator;

use App\Entity\ClothingItem;
use App\Entity\Outfit;
use App\Service\WeatherService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class SuggestionGeneratorService
{
    private const CATEGORIES = ['Coat', 'Top', 'Bottom', 'Shoes', 'Sweater', 'Dress'];
    private const WEATHER_TYPES = ['cold', 'cool', 'mild', 'warm', 'hot', 'rainy'];

    public function __construct(
        private readonly WeatherService         $weatherService,
        private readonly EntityManagerInterface $entityManager,
        private LoggerInterface                 $logger,
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function generateSuggestion(): array
    {
        $this->logger->info("Attempting to generate outfit suggestion");

        $weather = $this->weatherService->getWeather();
        $outfit = new Outfit();

        // TODO set either a top+bottom or a dress or an overall

        $top = $this->getRandomItemByWeatherAndCategory($weather, 'Top');
        $bottom = $this->getRandomItemByWeatherAndCategory($weather, 'Bottom');
        //        $shoes = $this->getRandomItemByWeatherAndCategory($weather, 'Shoes');
//        $coat = $this->getRandomItemByWeatherAndCategory($weather, 'Coat');
//        $sweater = $this->getRandomItemByWeatherAndCategory($weather, 'Sweater');
//        $dress = $this->getRandomItemByWeatherAndCategory($weather, 'Dress');

        $outfit
            ->setTop($top)
            ->setBottom($bottom)
//            ->setShoes($shoes)
//            ->setCoat($coat)
//            ->setSweater($sweater)
//            ->setDress($dress)
        ;

        if ($outfit->getId() === null) {
            $this->logger->error("Failed to generate outfit suggestion");
        }

        return [$weather, $outfit];
    }

    private function getRandomItemByWeatherAndCategory(string $weather, string $category): ClothingItem
    {
        $this->logger->info("Attempting to get items by weather { $weather }  and category { $category }");

        $weatherType = $this->determineWeatherType($weather);
        $items = $this->entityManager->getRepository(ClothingItem::class)->findItemByWeatherAndCategory($weatherType, $category);

        if (!empty($items)) {
            $this->logger->error("Failed to get items by weather { $weather }  and category { $category }");
            return $items[array_rand($items)];
        }

        return $items;
    }

    public function determineWeatherType(string $weather): string
    {
        $this->logger->info("Attempting to determine weatherType from weather { $weather }");

        foreach (self::WEATHER_TYPES as $type) {
            if (str_contains($weather, $type)) {
                return $type;
            }
        }
        return 'mild'; // default to mild if no match
    }

}
