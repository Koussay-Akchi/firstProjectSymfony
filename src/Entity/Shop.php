<?php

namespace App\Entity;

use App\Repository\ShopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShopRepository::class)]
class Shop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    /**
     * @var Collection<int, TV>
     */
    #[ORM\OneToMany(targetEntity: TV::class, mappedBy: 'shop')]
    private Collection $tVs;

    public function __construct()
    {
        $this->tVs = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, TV>
     */
    public function getTVs(): Collection
    {
        return $this->tVs;
    }

    public function addTV(TV $tV): static
    {
        if (!$this->tVs->contains($tV)) {
            $this->tVs->add($tV);
            $tV->setShop($this);
        }

        return $this;
    }

    public function removeTV(TV $tV): static
    {
        if ($this->tVs->removeElement($tV)) {
            // set the owning side to null (unless already changed)
            if ($tV->getShop() === $this) {
                $tV->setShop(null);
            }
        }

        return $this;
    }
}
