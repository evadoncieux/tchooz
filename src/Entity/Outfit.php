<?php

namespace App\Entity;

use App\Repository\OutfitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OutfitRepository::class)]
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

    #[ORM\ManyToOne(targetEntity: ClothingItem::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?ClothingItem $coat = null;

    #[ORM\ManyToOne(targetEntity: ClothingItem::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?ClothingItem $bottom = null;

    #[ORM\ManyToOne(targetEntity: ClothingItem::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?ClothingItem $dress = null;

    #[ORM\ManyToOne(targetEntity: ClothingItem::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?ClothingItem $shoes = null;

    #[ORM\ManyToOne(targetEntity: ClothingItem::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?ClothingItem $suit = null;

    #[ORM\ManyToOne(targetEntity: ClothingItem::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?ClothingItem $sweater = null;

    #[ORM\ManyToOne(targetEntity: ClothingItem::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?ClothingItem $top = null;

    #[ORM\ManyToOne(inversedBy: 'outfits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

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

    public function getCoat(): ?ClothingItem
    {
        return $this->coat;
    }

    public function setCoat(?ClothingItem $coat): static
    {
        $this->coat = $coat;

        return $this;
    }

    public function getBottom(): ?ClothingItem
    {
        return $this->bottom;
    }

    public function setBottom(?ClothingItem $bottom): static
    {
        $this->bottom = $bottom;

        return $this;
    }

    public function getDress(): ?ClothingItem
    {
        return $this->dress;
    }

    public function setDress(?ClothingItem $dress): static
    {
        $this->dress = $dress;

        return $this;
    }

    public function getShoes(): ?ClothingItem
    {
        return $this->shoes;
    }

    public function setShoes(?ClothingItem $shoes): static
    {
        $this->shoes = $shoes;

        return $this;
    }

    public function getSuit(): ?ClothingItem
    {
        return $this->suit;
    }

    public function setSuit(?ClothingItem $suit): static
    {
        $this->suit = $suit;

        return $this;
    }

    public function getSweater(): ?ClothingItem
    {
        return $this->sweater;
    }

    public function setSweater(?ClothingItem $sweater): static
    {
        $this->sweater = $sweater;

        return $this;
    }

    public function getTop(): ?ClothingItem
    {
        return $this->top;
    }

    public function setTop(?ClothingItem $top): static
    {
        $this->top = $top;

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
}
