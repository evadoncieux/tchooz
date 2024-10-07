<?php

namespace App\Service\ChoiceService;

use App\Service\WeatherTypeService;

class RecommandationGeneratorService
{
    public function __construct(private readonly WeatherTypeService $weatherTypeService,
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function generateRecommandation(): array
    {
        $weatherType = $this->weatherTypeService->getWeatherType();
        $recommandation = [];

        if ($weatherType->getName() === 'warm and sunny') {
            $recommandation = [
                'coat' => 'black and white jacket', /* or a element among an array of clothes fitting the weatherType*/
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
