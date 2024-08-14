<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[Broadcast]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, ClothingItem>
     */
    #[ORM\ManyToMany(targetEntity: ClothingItem::class, mappedBy: 'category')]
    private Collection $clothingItems;

    public function __construct()
    {
        $this->clothingItems = new ArrayCollection();
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
            $clothingItem->addCategory($this);
        }

        return $this;
    }

    public function removeClothingItem(ClothingItem $clothingItem): static
    {
        if ($this->clothingItems->removeElement($clothingItem)) {
            $clothingItem->removeCategory($this);
        }

        return $this;
    }
}
