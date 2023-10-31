<?php

namespace App\Entity;

use App\Repository\GarageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GarageRepository::class)]
class Garage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $capacity = null;

    #[ORM\OneToMany(mappedBy: 'garage', targetEntity: Tank::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $tank;

    #[ORM\ManyToOne(inversedBy: 'garage')]
    private ?Member $member = null;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->tank = new ArrayCollection();
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

    public function getCapacity(): ?string
    {
        return $this->capacity;
    }

    public function setCapacity(string $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * @return Collection<int, tank>
     */
    public function getTank(): Collection
    {
        return $this->tank;
    }

    public function addTank(tank $tank): static
    {
        if (!$this->tank->contains($tank)) {
            $this->tank->add($tank);
            $tank->setGarage($this);
        }

        return $this;
    }

    public function removeTank(tank $tank): static
    {
        if ($this->tank->removeElement($tank)) {
            // set the owning side to null (unless already changed)
            if ($tank->getGarage() === $this) {
                $tank->setGarage(null);
            }
        }

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): static
    {
        $this->member = $member;

        return $this;
    }
}
