<?php

namespace App\Entity;

use App\Repository\TVRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TVRepository::class)]
class TV
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tv_code = null;

    #[ORM\Column(length: 255)]
    private ?string $screen_size = null;

    #[ORM\Column]
    private ?bool $smarttv = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fabdate = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'tVs')]
    private ?Shop $shop = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTvCode(): ?string
    {
        return $this->tv_code;
    }

    public function setTvCode(string $tv_code): static
    {
        $this->tv_code = $tv_code;

        return $this;
    }

    public function getScreenSize(): ?string
    {
        return $this->screen_size;
    }

    public function setScreenSize(string $screen_size): static
    {
        $this->screen_size = $screen_size;

        return $this;
    }

    public function isSmarttv(): ?bool
    {
        return $this->smarttv;
    }

    public function setSmarttv(bool $smarttv): static
    {
        $this->smarttv = $smarttv;

        return $this;
    }

    public function getFabdate(): ?\DateTimeInterface
    {
        return $this->fabdate;
    }

    public function setFabdate(\DateTimeInterface $fabdate): static
    {
        $this->fabdate = $fabdate;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getShop(): ?Shop
    {
        return $this->shop;
    }

    public function setShop(?Shop $shop): static
    {
        $this->shop = $shop;

        return $this;
    }
}
