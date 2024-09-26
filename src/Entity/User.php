<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar = null;

    /**
     * @var Collection<int, Suggestion>
     */
    #[ORM\OneToMany(targetEntity: Suggestion::class, mappedBy: 'userSuggestions')]
    private Collection $suggestions;

    /**
     * @var Collection<int, Wardrobe>
     */
    #[ORM\OneToMany(targetEntity: Wardrobe::class, mappedBy: 'wardrobeUser')]
    private Collection $wardrobes;

    #[ORM\Column]
    private bool $isVerified = false;

    public function __construct()
    {
        $this->suggestions = new ArrayCollection();
        $this->wardrobes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->username;
    }

    /**
     * @return list<string>
     * @see UserInterface
     *
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): static
    {
        $this->avatar = $avatar;

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
            $suggestion->setUserSuggestions($this);
        }

        return $this;
    }

    public function removeSuggestion(Suggestion $suggestion): static
    {
        if ($this->suggestions->removeElement($suggestion)) {
            // set the owning side to null (unless already changed)
            if ($suggestion->getUserSuggestions() === $this) {
                $suggestion->setUserSuggestions(null);
            }
        }

        return $this;
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
            $wardrobe->setWardrobeUser($this);
        }

        return $this;
    }

    public function removeWardrobe(Wardrobe $wardrobe): static
    {
        if ($this->wardrobes->removeElement($wardrobe)) {
            // set the owning side to null (unless already changed)
            if ($wardrobe->getWardrobeUser() === $this) {
                $wardrobe->setWardrobeUser(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getUser(): static
    {
        return $this;
    }
}
