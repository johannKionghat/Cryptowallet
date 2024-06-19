<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use ArrayAccess;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: WalletRepository::class)]
class Wallet implements ArrayAccess
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\ManyToOne(inversedBy: 'IdWalet')]
    private ?User $IdUser = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'wallet', targetEntity: WalletCrypto::class)]
    private Collection $walletCryptos;

    public function __construct()
    {
        $this->walletCryptos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
            $walletCrypto->setWallet($this);
        }

        return $this;
    }

    public function removeWalletCrypto(WalletCrypto $walletCrypto): static
    {
        if ($this->walletCryptos->removeElement($walletCrypto)) {
            // set the owning side to null (unless already changed)
            if ($walletCrypto->getWallet() === $this) {
                $walletCrypto->setWallet(null);
            }
        }

        return $this;
    }
    // ArrayAccess methods
    public function offsetExists(mixed $offset): bool
    {
        return property_exists($this, $offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->$offset;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->$offset = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->$offset);
    }
}
