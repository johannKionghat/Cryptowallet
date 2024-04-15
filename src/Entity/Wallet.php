<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
class Wallet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $balance = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $SecretSentence = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBalance(): ?string
    {
        return $this->balance;
    }

    public function setBalance(string $balance): static
    {
        $this->balance = $balance;

        return $this;
    }

    public function getSecretSentence(): ?string
    {
        return $this->SecretSentence;
    }

    public function setSecretSentence(string $SecretSentence): static
    {
        $this->SecretSentence = $SecretSentence;

        return $this;
    }
}
