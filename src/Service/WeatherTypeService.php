<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\WeatherType;
use App\Service\Data\WeatherDataService;
use Symfony\Bundle\SecurityBundle\Security;

class WeatherTypeService
{
    /** temperature is measured in Celsius */
    private const TEMPERATURE_RANGES = [
        'very cold' => ['min' => -INF, 'max' => 9],
        'cold' => ['min' => 10, 'max' => 14],
        'cool' => ['min' => 15, 'max' => 19],
        'warm' => ['min' => 20, 'max' => 24],
        'hot' => ['min' => 25, 'max' => INF],
    ];

    /** wind speed is measured in km/h */
    private const WIND_SPEED_RANGES = [
        'no wind' => ['min' => -INF, 'max' => 2],
        'light breeze' => ['min' => 3, 'max' => 19],
        'breeze' => ['min' => 20, 'max' => 38],
        'wind' => ['min' => 39, 'max' => 49],
        'strong wind' => ['min' => 50, 'max' => INF],
    ];

    public function __construct(
        private readonly WeatherDataService $weatherDataService,
        protected Security                  $security
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function getWeatherType(?string $location = null): WeatherType
    {
        $user = $this->security->getUser();
        if (!$user instanceof User) {
            throw new \RuntimeException('User not found or not authenticated.');
        }

        $location = $location ?? $user->getLocation();
        if (!$location) {
            throw new \RuntimeException('Location not provided and not set for the user.');
        }

        try {
            $dailyWeather = $this->weatherDataService->getDailyWeather($location)
                ?? $this->weatherDataService->logWeather($location);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to retrieve weather data: ' . $e->getMessage(), 0, $e);
        }

        if (!$dailyWeather) {
            throw new \RuntimeException('No weather data available for the given location.');
        }

        $weatherType = new WeatherType();
        $temperature = $this->getTemperatureType($dailyWeather->getTemperature());
        $wind = $this->getWindSpeedType($dailyWeather->getWindSpeed());

        $weatherType->setName($this->determineWeatherTypeName($temperature, $wind));

        return $weatherType;
    }

    private function determineWeatherTypeName(string $temperature, string $wind): string
    {
        $combinations = [
            'very cold' => ['windy' => 'very cold & windy'],
            'cold' => ['breeze' => 'cold & breezy', 'windy' => 'cold & windy'],
            'warm' => ['windy' => 'warm & windy']
        ];

        return $combinations[$temperature][$wind] ?? "$temperature & $wind";
    }

    /**
     * @throws \Exception
     */
    private function getTemperatureType(float $temperature): string
    {
        return $this->getTypeFromRange($temperature, self::TEMPERATURE_RANGES);
    }

    /**
     * @throws \Exception
     */
    private function getWindSpeedType(float $windSpeed): string
    {
        return $this->getTypeFromRange($windSpeed, self::WIND_SPEED_RANGES);
    }

    /**
     * @throws \Exception
     */
    private function getTypeFromRange(float $value, array $ranges): string
    {
        foreach ($ranges as $type => $range) {
            if ($value > $range['min'] && $value <= $range['max']) {
                return $type;
            }
        }
        throw new \RuntimeException('Value out of defined ranges');
    }
}
