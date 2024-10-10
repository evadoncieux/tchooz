<?php

namespace App\Service\Weather;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;

class WeatherParametersService
{
    /** temperature is measured in Celsius */
    private const TEMPERATURE_RANGES = [
        'very cold' => ['min' => -INF, 'max' => 9],
        'cold' => ['min' => 9, 'max' => 14],
        'cool' => ['min' => 14, 'max' => 19],
        'warm' => ['min' => 19, 'max' => 24],
        'hot' => ['min' => 24, 'max' => INF],
    ];

    /** wind speed is measured in km/h */
    private const WIND_SPEED_RANGES = [
        'no wind' => ['min' => -INF, 'max' => 2],
        'light breeze' => ['min' => 2, 'max' => 19],
        'breeze' => ['min' => 19, 'max' => 39],
        'wind' => ['min' => 39, 'max' => 49],
        'strong wind' => ['min' => 49, 'max' => INF],
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
    public function getWeather(?string $location = null): string
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
            $currentWeather = $this->weatherDataService->getWeatherData($location);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to retrieve weather data: ' . $e->getMessage(), 0, $e);
        }

        if (!$currentWeather) {
            throw new \RuntimeException('No weather data available for the given location.');
        }

        $temperature = $this->getTemperatureType($currentWeather->getTemperature());
        $wind = $this->getWindSpeedType($currentWeather->getWindSpeed());

        return $this->determineWeatherName($temperature, $wind);
    }

    private function determineWeatherName(string $temperature, string $wind): string
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
