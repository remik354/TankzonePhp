<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
class Member
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Garage::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $garage;

    #[ORM\OneToMany(mappedBy: 'Member', targetEntity: Usine::class)]
    private Collection $usines;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Usine::class)]
    private Collection $usine;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->garage = new ArrayCollection();
        $this->usines = new ArrayCollection();
        $this->usine = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, garage>
     */
    public function getGarage(): Collection
    {
        return $this->garage;
    }

    public function addGarage(garage $garage): static
    {
        if (!$this->garage->contains($garage)) {
            $this->garage->add($garage);
            $garage->setMember($this);
        }

        return $this;
    }

    public function removeGarage(garage $garage): static
    {
        if ($this->garage->removeElement($garage)) {
            // set the owning side to null (unless already changed)
            if ($garage->getMember() === $this) {
                $garage->setMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Usine>
     */
    public function getUsines(): Collection
    {
        return $this->usines;
    }

    public function addUsine(Usine $usine): static
    {
        if (!$this->usines->contains($usine)) {
            $this->usines->add($usine);
            $usine->setMember($this);
        }

        return $this;
    }

    public function removeUsine(Usine $usine): static
    {
        if ($this->usines->removeElement($usine)) {
            // set the owning side to null (unless already changed)
            if ($usine->getMember() === $this) {
                $usine->setMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Usine>
     */
    public function getUsine(): Collection
    {
        return $this->usine;
    }
}
