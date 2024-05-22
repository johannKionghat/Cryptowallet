<?php

namespace App\Entity;

use App\Repository\RatingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RatingRepository::class)]
class Rating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $priceCrypto = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $ratingCrypto = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateRating = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriceCrypto(): ?string
    {
        return $this->priceCrypto;
    }

    public function setPriceCrypto(string $priceCrypto): static
    {
        $this->priceCrypto = $priceCrypto;

        return $this;
    }

    public function getRatingCrypto(): ?string
    {
        return $this->ratingCrypto;
    }

    public function setRatingCrypto(string $ratingCrypto): static
    {
        $this->ratingCrypto = $ratingCrypto;

        return $this;
    }

    public function getDateRating(): ?\DateTimeInterface
    {
        return $this->dateRating;
    }

    public function setDateRating(\DateTimeInterface $dateRating): static
    {
        $this->dateRating = $dateRating;

        return $this;
    }
}
