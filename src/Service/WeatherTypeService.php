<?php

namespace App\Service;

use App\Entity\WeatherType;
use App\Repository\WeatherTypeRepository;

class WeatherTypeService
{
    public function __construct(
        public readonly DailyWeather $weather,
        public readonly WeatherTypeRepository $weatherTypeRepository,
    )
    {

    }


    public function getWeatherType(): ?WeatherType
    {
        $weather = $this->weather;

        if ($weather['temperature'] < 25) {
            $weatherType = "warm";
        }
    }
}
