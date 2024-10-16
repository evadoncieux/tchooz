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
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClothingItemRepository::class)]
#[UniqueEntity(fields: ['name'], message: 'This name already exists!')]
class ClothingItem implements \Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['clothing_item'])]
    private ?string $name = null;

    /**
     * @var Collection<int, Outfit>
     */
    #[ORM\ManyToMany(targetEntity: Outfit::class, mappedBy: 'clothingItems')]
    private Collection $outfits;

    #[ORM\Column(type: 'string', enumType: ClothingMaterial::class)]
    private ?ClothingMaterial $material = null;

    #[ORM\Column(type: 'string', enumType: ClothingWeather::class)]
    private ClothingWeather $weather;

    #[ORM\Column(type: 'json')]
    private array $colors = [];

    #[ORM\Column(type: 'json')]
    private array $styles = [];

    #[ORM\Column(type: 'string', enumType: ClothingCategory::class)]
    private ClothingCategory $category;

    #[ORM\ManyToOne(inversedBy: 'clothingItems')]
    #[Groups(['clothing_item'])]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $timestamp = null;

    #[ORM\Column(length: 255)]
    #[Gedmo\Slug(fields: ['name'])]
    private ?string $slug = null;

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

    public function __toString()
    {
        return (string) $this->getName();
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
        return array_map(static fn($color) => ClothingColor::from($color), $this->colors);
    }

    public function setColors(array $colors): self
    {
        $this->colors = array_map(static fn(ClothingColor $color) => $color->value, $colors);
        return $this;

    }

    public function getMaterial(): ?ClothingMaterial
    {
        return $this->material;
    }

    public function setMaterial(?ClothingMaterial $material): self
    {
        $this->material = $material;
        return $this;
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

    public function getCategory(): ClothingCategory
    {
        return $this->category;
    }

    public function setCategory(?ClothingCategory $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getWeather(): ClothingWeather
    {
        return $this->weather ?? ClothingWeather::ANY;
    }

    public function setWeather(ClothingWeather $weather): self
    {
        $this->weather = $weather;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): static
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
