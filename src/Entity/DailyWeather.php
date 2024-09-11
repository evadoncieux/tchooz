<?php

namespace App\Entity;

use App\Repository\DailyWeatherRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: DailyWeatherRepository::class)]
#[Broadcast]
class DailyWeather // TODO ajouter des propriétés sur la base de a réponse de l'api
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "integer")]
    private ?int $temperature = null;

    #[ORM\ManyToOne]
    private ?WeatherType $weatherType = null;

    #[ORM\Column(type: "float")]
    private ?float $humidity = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $timestamp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemperature(): ?int
    {
        return $this->temperature;
    }

    public function setTemperature(?int $temperature): static
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

    public function getHumidity(): ?float
    {
        return $this->humidity;
    }

    public function setHumidity(float $humidity): static
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getTimestamp(): ?DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(DateTimeInterface $timestamp): static
    {
        $this->timestamp = $timestamp;

        return $this;
    }
}
