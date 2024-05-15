<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
class Wallet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantityCrypto = null;

    #[ORM\ManyToOne(inversedBy: 'IdWalet')]
    private ?User $IdUser = null;

    #[ORM\OneToMany(mappedBy: 'IdWallet', targetEntity: Cryptocurrency::class)]
    private Collection $IdCryptocurrency;
    public function __construct()
    {
        $this->IdCryptocurrency = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantityCrypto(): ?int
    {
        return $this->quantityCrypto;
    }

    public function setQuantityCrypto(?int $quantityCrypto): static
    {
        $this->quantityCrypto = $quantityCrypto;

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

    /**
     * @return Collection<int, Cryptocurrency>
     */
    public function getIdCryptocurrency(): Collection
    {
        return $this->IdCryptocurrency;
    }

    public function addIdCryptocurrency(Cryptocurrency $idCryptocurrency): static
    {
        if (!$this->IdCryptocurrency->contains($idCryptocurrency)) {
            $this->IdCryptocurrency->add($idCryptocurrency);
            $idCryptocurrency->setIdWallet($this);
        }

        return $this;
    }

    public function removeIdCryptocurrency(Cryptocurrency $idCryptocurrency): static
    {
        if ($this->IdCryptocurrency->removeElement($idCryptocurrency)) {
            // set the owning side to null (unless already changed)
            if ($idCryptocurrency->getIdWallet() === $this) {
                $idCryptocurrency->setIdWallet(null);
            }
        }

        return $this;
    }
}
