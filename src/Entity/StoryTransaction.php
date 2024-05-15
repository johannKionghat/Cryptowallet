<?php

namespace App\Entity;

use App\Repository\StoryTransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StoryTransactionRepository::class)]
class StoryTransaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $TypeAction = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $DescriptionAction = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateActionAT = null;

    #[ORM\ManyToOne(inversedBy: 'IdStoryTransaction')]
    private ?User $IdUser = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Transaction $idTransaction = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeAction(): ?string
    {
        return $this->TypeAction;
    }

    public function setTypeAction(?string $TypeAction): static
    {
        $this->TypeAction = $TypeAction;

        return $this;
    }

    public function getDescriptionAction(): ?string
    {
        return $this->DescriptionAction;
    }

    public function setDescriptionAction(?string $DescriptionAction): static
    {
        $this->DescriptionAction = $DescriptionAction;

        return $this;
    }

    public function getDateActionAT(): ?\DateTimeInterface
    {
        return $this->DateActionAT;
    }

    public function setDateActionAT(?\DateTimeInterface $DateActionAT): static
    {
        $this->DateActionAT = $DateActionAT;

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

    public function getIdTransaction(): ?Transaction
    {
        return $this->idTransaction;
    }

    public function setIdTransaction(?Transaction $idTransaction): static
    {
        $this->idTransaction = $idTransaction;

        return $this;
    }
}
