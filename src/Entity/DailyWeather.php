<?php

namespace App\Entity;

use App\Repository\DailyWeatherRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: DailyWeatherRepository::class)]
#[Broadcast]
class DailyWeather
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?Temperature $temperature = null;

    #[ORM\ManyToOne]
    private ?WeatherType $weatherType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemperature(): ?Temperature
    {
        return $this->temperature;
    }

    public function setTemperature(?Temperature $temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getWeatherType(): ?WeatherType
    {
        return $this->weatherType;
    }

    public function setWeatherType(?WeatherType $weatherType): static
    {
        $this->weatherType = $weatherType;

        return $this;
    }
}
