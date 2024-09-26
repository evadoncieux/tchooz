<?php

namespace App\Entity;

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

    /**
     * @var Collection<int, Wardrobe>
     */
    #[ORM\ManyToMany(targetEntity: Wardrobe::class, mappedBy: 'items')]
    private Collection $wardrobes;

    /**
     * @var Collection<int, Outfit>
     */
    #[ORM\ManyToMany(targetEntity: Outfit::class, mappedBy: 'clothingItems')]
    private Collection $outfits;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'clothingItems')]
    private Collection $categories;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $color = null;

    #[ORM\Column(length: 255)]
    private ?string $material = null;

    /**
     * @var Collection<int, WeatherType>
     */
    #[ORM\ManyToMany(targetEntity: WeatherType::class, inversedBy: 'clothingItems')]
    private Collection $weatherTypes;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $style = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?array $occasions = null;

    public function __construct()
    {
        $this->wardrobes = new ArrayCollection();
        $this->outfits = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->weatherTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Wardrobe>
     */
    public function getWardrobes(): Collection
    {
        return $this->wardrobes;
    }

    public function addWardrobe(Wardrobe $wardrobe): static
    {
        if (!$this->wardrobes->contains($wardrobe)) {
            $this->wardrobes->add($wardrobe);
            $wardrobe->addItem($this);
        }

        return $this;
    }

    public function removeWardrobe(Wardrobe $wardrobe): static
    {
        if ($this->wardrobes->removeElement($wardrobe)) {
            $wardrobe->removeItem($this);
        }

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

    /**
     * @return Collection<int, Category>
     */
    public function getCategory(): Collection
    {
        return $this->categories;
    }

    public function setCategory(Collection $categories): void
    {
        $this->categories = $categories;
    }

    public function addCategory(Category $categories): static
    {
        if (!$this->categories->contains($categories)) {
            $this->categories->add($categories);
        }

        return $this;
    }

    public function removeCategory(Category $categories): static
    {
        $this->categories->removeElement($categories);

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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getMaterial(): ?string
    {
        return $this->material;
    }

    public function setMaterial(string $material): static
    {
        $this->material = $material;

        return $this;
    }

    /**
     * @return Collection<int, WeatherType>
     */
    public function getWeatherTypes(): Collection
    {
        return $this->weatherTypes;
    }

    public function addWeatherType(WeatherType $weatherType): static
    {
        if (!$this->weatherTypes->contains($weatherType)) {
            $this->weatherTypes->add($weatherType);
        }

        return $this;
    }

    public function removeWeatherType(WeatherType $weatherType): static
    {
        $this->weatherTypes->removeElement($weatherType);

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(?string $style): static
    {
        $this->style = $style;

        return $this;
    }

    public function getOccasions(): ?array
    {
        return $this->occasions;
    }

    public function setOccasions(?array $occasions): static
    {
        $this->occasions = $occasions;

        return $this;
    }
}
