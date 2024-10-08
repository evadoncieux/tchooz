<?php

namespace App\Entity;

use App\Enum\ClothingCategory;
use App\Enum\ClothingColor;
use App\Enum\ClothingMaterial;
use App\Enum\ClothingStyle;
use App\Enum\ClothingWeather;
use App\Repository\ClothingItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClothingItemRepository::class)]
class ClothingItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, Outfit>
     */
    #[ORM\ManyToMany(targetEntity: Outfit::class, mappedBy: 'clothingItems')]
    private Collection $outfits;

    #[ORM\Column(type: 'string', enumType: ClothingMaterial::class)]
    private ?ClothingMaterial $material = null;

    #[ORM\Column(type: 'string', enumType: ClothingWeather::class)]
    private ?ClothingWeather $weather;

    #[ORM\Column(type: 'json')]
    private array $colors = [];

    #[ORM\Column(type: 'json')]
    private array $styles = [];

    #[ORM\Column(type: 'json')]
    private array $categories = [];

    public function __construct()
    {
        $this->outfits = new ArrayCollection();
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
     * @return Collection<int, Outfit>
     */
    public function getOutfits(): Collection
    {
        return $this->outfits;
    }

    public function addOutfit(Outfit $outfit): static
    {
        if (!$this->outfits->contains($outfit)) {
            $this->outfits->add($outfit);
            $outfit->addClothingItem($this);
        }

        return $this;
    }

    public function removeOutfit(Outfit $outfit): static
    {
        if ($this->outfits->removeElement($outfit)) {
            $outfit->removeClothingItem($this);
        }

        return $this;
    }

    public function getColors(): array
    {
        return array_map(fn($color) => ClothingColor::from($color), $this->colors);
    }

    public function setColors(array $colors): self
    {
        $this->colors = array_map(fn(ClothingColor $color) => $color->value, $colors);
        return $this;
    }

    public function getMaterial(): ?ClothingMaterial
    {
        return $this->material;
    }

    public function setMaterial(?ClothingMaterial $material): void
    {
        $this->material = $material;
    }

    public function getStyles(): array
    {
        return array_map(fn($style) => ClothingStyle::from($style), $this->styles);
    }

    public function setStyles(array $styles): self
    {
        $this->styles = array_map(static fn(ClothingStyle $style) => $style->value, $styles);
        return $this;
    }

    public function getCategories(): array
    {
        return array_map(static fn($category) => ClothingCategory::from($category), $this->categories);
    }

    public function setCategories(array $categories): self
    {
        $this->categories = array_map(static fn(ClothingCategory $category) => $category->value, $categories);
        return $this;
    }

    public function getWeather(): ?ClothingWeather
    {
        return $this->weather;
    }

    public function setWeather(?ClothingWeather $weather): void
    {
        $this->weather = $weather;
    }
}
