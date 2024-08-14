<?php

namespace App\Entity;

use App\Repository\SuggestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: SuggestionRepository::class)]
#[Broadcast]
class Suggestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $suggestedOutfit = null;

    /**
     * @var Collection<int, Outfit>
     */
    #[ORM\ManyToMany(targetEntity: Outfit::class, inversedBy: 'suggestions')]
    private Collection $outfits;

    #[ORM\ManyToOne(inversedBy: 'suggestions')]
    private ?User $userSuggestions = null;

    /**
     * @var Collection<int, Factor>
     */
    #[ORM\OneToMany(targetEntity: Factor::class, mappedBy: 'suggestion')]
    private Collection $factor;

    public function __construct()
    {
        $this->outfits = new ArrayCollection();
        $this->factor = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSuggestedOutfit(): ?array
    {
        return $this->suggestedOutfit;
    }

    public function setSuggestedOutfit(?array $suggestedOutfit): static
    {
        $this->suggestedOutfit = $suggestedOutfit;

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
        }

        return $this;
    }

    public function removeOutfit(Outfit $outfit): static
    {
        $this->outfits->removeElement($outfit);

        return $this;
    }

    public function getUserSuggestions(): ?User
    {
        return $this->userSuggestions;
    }

    public function setUserSuggestions(?User $userSuggestions): static
    {
        $this->userSuggestions = $userSuggestions;

        return $this;
    }

    /**
     * @return Collection<int, Factor>
     */
    public function getFactor(): Collection
    {
        return $this->factor;
    }

    public function addFactor(Factor $factor): static
    {
        if (!$this->factor->contains($factor)) {
            $this->factor->add($factor);
            $factor->setSuggestion($this);
        }

        return $this;
    }

    public function removeFactor(Factor $factor): static
    {
        if ($this->factor->removeElement($factor)) {
            // set the owning side to null (unless already changed)
            if ($factor->getSuggestion() === $this) {
                $factor->setSuggestion(null);
            }
        }

        return $this;
    }
}
