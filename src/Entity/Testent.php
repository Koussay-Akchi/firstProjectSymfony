<?php

namespace App\Entity;

use App\Repository\TestentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestentRepository::class)]
class Testent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $string = null;

    #[ORM\Column(nullable: true)]
    private ?bool $test = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getString(): ?string
    {
        return $this->string;
    }

    public function setString(?string $string): static
    {
        $this->string = $string;

        return $this;
    }

    public function isTest(): ?bool
    {
        return $this->test;
    }

    public function setTest(?bool $test): static
    {
        $this->test = $test;

        return $this;
    }
}
