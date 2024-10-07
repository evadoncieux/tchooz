<?php

namespace App\Entity;

use App\Repository\DailyWeatherRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DailyWeatherRepository::class)]
class DailyWeather
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

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $tempMin = null;

    #[ORM\Column]
    private ?float $tempMax = null;

    #[ORM\Column]
    private ?float $windSpeed = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $sunrise = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $sunset = null;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getSunrise(): ?\DateTimeInterface
    {
        return $this->sunrise;
    }

    public function setSunrise(\DateTimeInterface $sunrise): static
    {
        $this->sunrise = $sunrise;

        return $this;
    }

    public function getSunset(): ?\DateTimeInterface
    {
        return $this->sunset;
    }

    public function setSunset(\DateTimeInterface $sunset): static
    {
        $this->sunset = $sunset;

        return $this;
    }

}
