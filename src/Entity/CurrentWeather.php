<?php

namespace App\Entity;

use App\Repository\DailyWeatherRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DailyWeatherRepository::class)]
class CurrentWeather
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $timestamp = null;

    #[ORM\Column(type: "integer")]
    private ?int $temperature = null;

    #[ORM\Column]
    private ?float $temp_feels = null;

    #[ORM\Column(nullable: true)]
    private ?float $tempMin = null;

    #[ORM\Column(nullable: true)]
    private ?float $tempMax = null;

    #[ORM\Column]
    private ?float $windSpeed = null;

    #[ORM\Column(nullable: true)]
    private ?float $rain = null;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getTempMin(): ?float
    {
        return $this->tempMin;
    }

    public function setTempMin(float $tempMin): static
    {
        $this->tempMin = $tempMin;

        return $this;
    }

    public function getTempMax(): ?float
    {
        return $this->tempMax;
    }

    public function setTempMax(float $tempMax): static
    {
        $this->tempMax = $tempMax;

        return $this;
    }

    public function getWindSpeed(): ?float
    {
        return $this->windSpeed;
    }

    public function setWindSpeed(float $windSpeed): static
    {
        $this->windSpeed = $windSpeed;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getTempFeels(): ?float
    {
        return $this->temp_feels;
    }

    public function setTempFeels(float $temp_feels): static
    {
        $this->temp_feels = $temp_feels;

        return $this;
    }

    public function getRain(): ?float
    {
        return $this->rain;
    }

    public function setRain(float $rain): static
    {
        $this->rain = $rain;

        return $this;
    }
}
