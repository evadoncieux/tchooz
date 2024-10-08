<?php

namespace App\Entity;

use App\Repository\SuggestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuggestionRepository::class)]
class Suggestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true)]
    private ?array $suggestedOutfit = null;

    /**
     * @var Collection<int, Outfit>
     */
    #[ORM\ManyToMany(targetEntity: Outfit::class, inversedBy: 'suggestions')]
    private Collection $outfits;

    #[ORM\ManyToOne(inversedBy: 'suggestions')]
    private ?User $userSuggestions = null;

    public function __construct()
    {
        $this->outfits = new ArrayCollection();
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
}
