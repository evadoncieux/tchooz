<?php

namespace App\Enum;

enum ClothingWeather: string
{
    case SUNNY = 'Sunny';
    case WARM = 'Warm';
    case HOT = 'Hot';
    case COLD = 'Cold';
    case COOL = 'Cool';
    case RAINY = 'Rainy';
    case SNOWY = 'Snowy';
    case WINDY = 'Windy';
    case CLOUDY = 'Cloudy';
    case STORMY = 'Stormy';
    case FREEZING = 'Freezing';
    case MILD = 'Mild';
    case BREEZY = 'Breezy';
    case ANY = 'Any';

    public static function getSortOrder(): array
    {
        return [
            self::ANY,
            self::HOT,
            self::WARM,
            self::COOL,
            self::COLD,
            self::RAINY,
        ];
    }
}
