<?php

namespace App\Entity;

use App\Repository\OutfitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: OutfitRepository::class)]
#[Broadcast]
class Outfit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, ClothingItem>
     */
    #[ORM\ManyToMany(targetEntity: ClothingItem::class, inversedBy: 'outfits')]
    private Collection $clothingItems;

    /**
     * @var Collection<int, Suggestion>
     */
    #[ORM\ManyToMany(targetEntity: Suggestion::class, mappedBy: 'outfits')]
    private Collection $suggestions;

    public function __construct()
    {
        $this->clothingItems = new ArrayCollection();
        $this->suggestions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, ClothingItem>
     */
    public function getClothingItems(): Collection
    {
        return $this->clothingItems;
    }

    public function addClothingItem(ClothingItem $clothingItem): static
    {
        if (!$this->clothingItems->contains($clothingItem)) {
            $this->clothingItems->add($clothingItem);
        }

        return $this;
    }

    public function removeClothingItem(ClothingItem $clothingItem): static
    {
        $this->clothingItems->removeElement($clothingItem);

        return $this;
    }

    /**
     * @return Collection<int, Suggestion>
     */
    public function getSuggestions(): Collection
    {
        return $this->suggestions;
    }

    public function addSuggestion(Suggestion $suggestion): static
    {
        if (!$this->suggestions->contains($suggestion)) {
            $this->suggestions->add($suggestion);
            $suggestion->addOutfit($this);
        }

        return $this;
    }

    public function removeSuggestion(Suggestion $suggestion): static
    {
        if ($this->suggestions->removeElement($suggestion)) {
            $suggestion->removeOutfit($this);
        }

        return $this;
    }
}
