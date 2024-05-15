<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateTransactionAT = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $TypeTransaction = null;

    #[ORM\Column(nullable: true)]
    private ?int $AmountTransaction = null;

    #[ORM\Column(nullable: true)]
    private ?int $PriceCrypto = null;

    #[ORM\ManyToOne(inversedBy: 'IdTransaction')]
    private ?User $IdUser = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Cryptocurrency $IdCryptocurrency = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateTransactionAT(): ?\DateTimeInterface
    {
        return $this->DateTransactionAT;
    }

    public function setDateTransactionAT(?\DateTimeInterface $DateTransactionAT): static
    {
        $this->DateTransactionAT = $DateTransactionAT;

        return $this;
    }

    public function getTypeTransaction(): ?string
    {
        return $this->TypeTransaction;
    }

    public function setTypeTransaction(?string $TypeTransaction): static
    {
        $this->TypeTransaction = $TypeTransaction;

        return $this;
    }

    public function getAmountTransaction(): ?int
    {
        return $this->AmountTransaction;
    }

    public function setAmountTransaction(?int $AmountTransaction): static
    {
        $this->AmountTransaction = $AmountTransaction;

        return $this;
    }

    public function getPriceCrypto(): ?int
    {
        return $this->PriceCrypto;
    }

    public function setPriceCrypto(?int $PriceCrypto): static
    {
        $this->PriceCrypto = $PriceCrypto;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->IdUser;
    }

    public function setIdUser(?User $IdUser): static
    {
        $this->IdUser = $IdUser;

        return $this;
    }

    public function getIdCryptocurrency(): ?Cryptocurrency
    {
        return $this->IdCryptocurrency;
    }

    public function setIdCryptocurrency(?Cryptocurrency $IdCryptocurrency): static
    {
        $this->IdCryptocurrency = $IdCryptocurrency;

        return $this;
    }
}
