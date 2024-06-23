<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    private ?WalletCrypto $walletCrypto = null;

    #[ORM\Column]
    private ?float $amountCrypto = null;

    #[ORM\Column]
    private ?float $amountEuro = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateAt = null;

    #[ORM\ManyToOne(inversedBy: 'usersToTransaction')]
    private ?User $userTo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getWalletCrypto(): ?WalletCrypto
    {
        return $this->walletCrypto;
    }

    public function setWalletCrypto(?WalletCrypto $walletCrypto): static
    {
        $this->walletCrypto = $walletCrypto;

        return $this;
    }

    public function getAmountCrypto(): ?float
    {
        return $this->amountCrypto;
    }

    public function setAmountCrypto(float $amountCrypto): static
    {
        $this->amountCrypto = $amountCrypto;

        return $this;
    }

    public function getAmountEuro(): ?float
    {
        return $this->amountEuro;
    }

    public function setAmountEuro(float $amountEuro): static
    {
        $this->amountEuro = $amountEuro;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDateAt(): ?\DateTimeImmutable
    {
        return $this->dateAt;
    }

    public function setDateAt(\DateTimeImmutable $dateAt): static
    {
        $this->dateAt = $dateAt;

        return $this;
    }

    public function getUserTo(): ?User
    {
        return $this->userTo;
    }

    public function setUserTo(?User $userTo): static
    {
        $this->userTo = $userTo;

        return $this;
    }
}
