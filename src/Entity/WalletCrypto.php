<?php

namespace App\Entity;

use App\Repository\WalletCryptoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WalletCryptoRepository::class)]
class WalletCrypto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $solde = null;

    #[ORM\Column]
    private ?bool $activation = null;

    #[ORM\ManyToOne(inversedBy: 'walletCryptos')]
    private ?Wallet $wallet = null;

    #[ORM\ManyToOne(inversedBy: 'walletCryptos')]
    private ?Cryptocurrency $crypto = null;

    #[ORM\Column(length: 255)]
    private ?string $nameCrypto = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getSolde(): ?string
    {
        return $this->solde;
    }

    public function setSolde(string $solde): static
    {
        $this->solde = $solde;

        return $this;
    }

    public function isActivation(): ?bool
    {
        return $this->activation;
    }

    public function setActivation(bool $activation): static
    {
        $this->activation = $activation;

        return $this;
    }

    public function getWallet(): ?Wallet
    {
        return $this->wallet;
    }

    public function setWallet(?Wallet $wallet): static
    {
        $this->wallet = $wallet;

        return $this;
    }

    public function getCrypto(): ?Cryptocurrency
    {
        return $this->crypto;
    }

    public function setCrypto(?Cryptocurrency $crypto): static
    {
        $this->crypto = $crypto;

        return $this;
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
}
