<?php

namespace App\Service\OutfitGenerator;

use App\Entity\ClothingItem;
use App\Entity\Outfit;
use App\Entity\User;
use App\Service\Weather\WeatherParametersService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\SecurityBundle\Security;

// TODO voir si on peut réarranger ce service, y'a surement des trucs à mettre dans une autre classe pour plus de clarté
class OutfitGeneratorService
{
    private const WEATHER_TYPES = ['cold', 'cool', 'mild', 'warm', 'hot', 'rainy'];

    public function __construct(
        private readonly WeatherParametersService $weatherParametersService,
        private readonly EntityManagerInterface   $entityManager,
        private readonly LoggerInterface          $logger,
        protected Security                        $security,
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function generateSuggestion(): array
    {
        $this->logger->info("Attempting to generate outfit suggestion");

        $weather = $this->weatherParametersService->getWeather();
        $weatherType = $this->determineWeatherType($weather);
        $user = $this->security->getUser();
        if (!$user instanceof User) {
            throw new \RuntimeException('User not found or not authenticated.');
        }

        $outfit = new Outfit();

//        TODO check if the newly selected items are the same as the previous outfits, otherwise ???
        $lastLoggedOutfit = $this->lastLoggedOutfit($user);
        if (!$lastLoggedOutfit) {

            $shoes = $this->getRandomItemByWeatherAndCategory($weather, 'Shoes');
            $outfit->setShoes($shoes);

            if ($weatherType === 'hot') {
                $dress = $this->getRandomItemByWeatherAndCategory($weather, 'Dress');
                $outfit->setDress($dress);
            }

            if ($weatherType === 'cool' || $weatherType === 'mild') {
                $top = $this->getRandomItemByWeatherAndCategory($weather, 'Top');
                $bottom = $this->getRandomItemByWeatherAndCategory($weather, 'Bottom');
                $outfit
                    ->setTop($top)
                    ->setBottom($bottom);
            }

            if ($weatherType === 'cool' || $weatherType === 'cold') {
                $coat = $this->getRandomItemByWeatherAndCategory($weather, 'Coat');
                $sweater = $this->getRandomItemByWeatherAndCategory($weather, 'Sweater');
                $outfit->setCoat($coat)
                    ->setSweater($sweater);
            }

            $outfit->setUser($user);

            $this->entityManager->persist($outfit);
            $this->entityManager->flush();

            $this->logger->notice("Success in generating outfit suggestion");

            return [$weather, $outfit];
        }
        return [$weather, $outfit];
    }

    private function getRandomItemByWeatherAndCategory(string $weather, string $category): ClothingItem|null
    {
        $weatherType = $this->determineWeatherType($weather);
        $this->logger->info("Attempting to get items by weather { $weatherType }  and category { $category }");

        $clothingItem = $this->entityManager->getRepository(ClothingItem::class)->findItemByWeatherAndCategory($weatherType, $category);

        if (empty($clothingItem)) {
            $this->logger->error("Failed to get items by weather { $weatherType }  and category { $category }");
            return null;
        }

        $this->logger->notice("Success in getting items by weather { $weatherType }  and category { $category }");
        return $clothingItem[array_rand($clothingItem)];
    }

    public function determineWeatherType(string $weather): string
    {
        $this->logger->info("Attempting to determine weatherType from weather { $weather }");

        foreach (self::WEATHER_TYPES as $type) {
            if (str_contains($weather, $type)) {
                return $type;
            }
        }
        return 'mild';
    }

    private function lastLoggedOutfit($user): array
    {

        return $this->entityManager->getRepository(Outfit::class)->findBy(['user' => $user]);
    }

}
