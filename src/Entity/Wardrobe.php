<?php

namespace App\Entity;

use App\Repository\WardrobeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WardrobeRepository::class)]
class Wardrobe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $clothingItems = null;

    /**
     * @var Collection<int, ClothingItem>
     */
    #[ORM\ManyToMany(targetEntity: ClothingItem::class, inversedBy: 'wardrobes')]
    private Collection $items;

    #[ORM\ManyToOne(inversedBy: 'wardrobes')]
    private ?User $wardrobeUser = null;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getClothingItems(): ?array
    {
        return $this->clothingItems;
    }

    public function setClothingItems(?array $clothingItems): static
    {
        $this->clothingItems = $clothingItems;

        return $this;
    }

    /**
     * @return Collection<int, ClothingItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(ClothingItem $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
        }

        return $this;
    }

    public function removeItem(ClothingItem $item): static
    {
        $this->items->removeElement($item);

        return $this;
    }

    public function getWardrobeUser(): ?User
    {
        return $this->wardrobeUser;
    }

    public function setWardrobeUser(?User $wardrobeUser): static
    {
        $this->wardrobeUser = $wardrobeUser;

        return $this;
    }
}
