<?php

namespace App\Entity;

use App\Repository\CryptoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CryptoRepository::class)]
class Crypto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameCrypto = null;

    #[ORM\Column(length: 255)]
    private ?string $shortNameCrypto = null;

    #[ORM\Column(length: 255)]
    private ?string $logoCrypto = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameCrypto(): ?string
    {
        return $this->nameCrypto;
    }

    public function setNameCrypto(string $nameCrypto): static
    {
        $this->nameCrypto = $nameCrypto;

        return $this;
    }

    public function getShortNameCrypto(): ?string
    {
        return $this->shortNameCrypto;
    }

    public function setShortNameCrypto(string $shortNameCrypto): static
    {
        $this->shortNameCrypto = $shortNameCrypto;

        return $this;
    }

    public function getLogoCrypto(): ?string
    {
        return $this->logoCrypto;
    }

    public function setLogoCrypto(string $logoCrypto): static
    {
        $this->logoCrypto = $logoCrypto;

        return $this;
    }
}
