<?php

namespace App\Entity;

use App\Repository\SeasonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeasonRepository::class)]
class Season
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, WeatherType>
     */
    #[ORM\ManyToMany(targetEntity: WeatherType::class, inversedBy: 'seasons')]
    private Collection $weatherType;

    public function __construct()
    {
        $this->weatherType = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, WeatherType>
     */
    public function getWeatherType(): Collection
    {
        return $this->weatherType;
    }

    public function addWeatherType(WeatherType $weatherType): static
    {
        if (!$this->weatherType->contains($weatherType)) {
            $this->weatherType->add($weatherType);
        }

        return $this;
    }

    public function removeWeatherType(WeatherType $weatherType): static
    {
        $this->weatherType->removeElement($weatherType);

        return $this;
    }
}
