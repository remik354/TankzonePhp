<?php

namespace App\Entity;

use App\Repository\UsineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsineRepository::class)]
class Usine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $public = null;   

    #[ORM\ManyToOne(inversedBy: 'usine')]
    private ?Member $member = null;

    #[ORM\ManyToMany(targetEntity: Tank::class, inversedBy: 'usine')]
    private Collection $tanks;

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
        $this->tanks = new ArrayCollection();
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

    public function isPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): static
    {
        $this->public = $public;

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

    /**
     * @return Collection<int, Tank>
     */
    public function getTanks(): Collection
    {
        return $this->tanks;
    }

    public function addTank(Tank $tank): static
    {
        if (!$this->tanks->contains($tank)) {
            $this->tanks->add($tank);
        }

        return $this;
    }

    public function removeTank(Tank $tank): static
    {
        $this->tanks->removeElement($tank);

        return $this;
    }
}