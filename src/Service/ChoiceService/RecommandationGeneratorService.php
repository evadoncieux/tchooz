<?php

namespace App\Service\ChoiceService;

use App\Service\WeatherService;

class RecommandationGeneratorService
{
    public function __construct(private readonly WeatherService $weatherService,
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function generateRecommandation(): array
    {
        $weather = $this->weatherService->getWeather();
        $recommandation = [];

        if ($weather->getName() === 'warm and sunny') {
            $recommandation = [
                'coat' => 'black and white jacket', /* or a element among an array of clothes fitting the weather*/
                'top' => 'black long sleep t-shirt',
                'sweater' => 'black hoodie',
                'bottom' => 'black jeans',
                'shoes' => 'Dr. Martens',
                'hat' => 'no',
            ];
        }

        return $recommandation;
    }


}
