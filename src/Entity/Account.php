<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameAccount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameAccount(): ?string
    {
        return $this->nameAccount;
    }

    public function setNameAccount(string $nameAccount): static
    {
        $this->nameAccount = $nameAccount;

        return $this;
    }
}
