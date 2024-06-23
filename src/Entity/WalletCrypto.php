<?php

namespace App\Entity;

use App\Repository\WalletCryptoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WalletCryptoRepository::class)]
class WalletCrypto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '6')]
    private ?string $solde = null;
    
    #[ORM\Column]
    private ?bool $activation = null;

    #[ORM\ManyToOne(inversedBy: 'walletCryptos')]
    private ?Wallet $wallet = null;

    #[ORM\ManyToOne(inversedBy: 'walletCryptos')]
    private ?Cryptocurrency $crypto = null;

    #[ORM\Column(length: 255)]
    private ?string $nameCrypto = null;

    #[ORM\OneToMany(mappedBy: 'walletCrypto', targetEntity: Transaction::class)]
    private Collection $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): static
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
            $transaction->setWalletCrypto($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getWalletCrypto() === $this) {
                $transaction->setWalletCrypto(null);
            }
        }

        return $this;
    }
}
