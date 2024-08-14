<?php

namespace App\Entity;

use App\Repository\FactorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactorRepository::class)]
class Factor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $weather = null;

    #[ORM\Column(length: 255)]
    private ?string $mood = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?DailyWeather $dailyWeather = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?DailyMood $dailyMood = null;

    #[ORM\ManyToOne(inversedBy: 'factor')]
    private ?Suggestion $suggestion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeather(): ?string
    {
        return $this->weather;
    }

    public function setWeather(string $weather): static
    {
        $this->weather = $weather;

        return $this;
    }

    public function getMood(): ?string
    {
        return $this->mood;
    }

    public function setMood(string $mood): static
    {
        $this->mood = $mood;

        return $this;
    }

    public function getDailyWeather(): ?DailyWeather
    {
        return $this->dailyWeather;
    }

    public function setDailyWeather(?DailyWeather $dailyWeather): static
    {
        $this->dailyWeather = $dailyWeather;

        return $this;
    }

    public function getDailyMood(): ?DailyMood
    {
        return $this->dailyMood;
    }

    public function setDailyMood(?DailyMood $dailyMood): static
    {
        $this->dailyMood = $dailyMood;

        return $this;
    }

    public function getSuggestion(): ?Suggestion
    {
        return $this->suggestion;
    }

    public function setSuggestion(?Suggestion $suggestion): static
    {
        $this->suggestion = $suggestion;

        return $this;
    }
}
