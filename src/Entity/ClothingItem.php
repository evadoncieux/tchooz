<?php

namespace App\Entity;

use App\Repository\ClothingItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: ClothingItemRepository::class)]
#[Broadcast]
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
    private Collection $category;

    public function __construct()
    {
        $this->wardrobes = new ArrayCollection();
        $this->outfits = new ArrayCollection();
        $this->category = new ArrayCollection();
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
        return $this->category;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->category->removeElement($category);

        return $this;
    }
}
