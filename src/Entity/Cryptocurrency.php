<?php

namespace App\Entity;

use App\Repository\CryptocurrencyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CryptocurrencyRepository::class)]
#[UniqueEntity(fields:['Name'], message:'This value is already used.')]

class Cryptocurrency
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $image = 'avatar.png';

    #[ORM\Column(length: 255)]
    private ?string $Abreviation = 'null';

    #[ORM\OneToMany(mappedBy: 'crypto', targetEntity: WalletCrypto::class)]
    private Collection $walletCryptos;

    public function __construct()
    {
        $this->walletCryptos = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getAbreviation(): ?string
    {
        return $this->Abreviation;
    }

    public function setAbreviation(string $Abreviation): static
    {
        $this->Abreviation = $Abreviation;

        return $this;
    }

    /**
     * @return Collection<int, WalletCrypto>
     */
    public function getWalletCryptos(): Collection
    {
        return $this->walletCryptos;
    }

    public function addWalletCrypto(WalletCrypto $walletCrypto): static
    {
        if (!$this->walletCryptos->contains($walletCrypto)) {
            $this->walletCryptos->add($walletCrypto);
            $walletCrypto->setCrypto($this);
        }

        return $this;
    }

    public function removeWalletCrypto(WalletCrypto $walletCrypto): static
    {
        if ($this->walletCryptos->removeElement($walletCrypto)) {
            // set the owning side to null (unless already changed)
            if ($walletCrypto->getCrypto() === $this) {
                $walletCrypto->setCrypto(null);
            }
        }

        return $this;
    }
}
