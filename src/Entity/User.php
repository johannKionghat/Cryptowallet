<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $countryFrom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cityFrom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateBirth = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $countryBirth = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cityBirth = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(nullable: true)]
    private ?int $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageProfil = null;

    #[ORM\Column(nullable: true)]
    private ?int $zipcode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $language = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateAT = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $currency = 'EUR';

    #[ORM\Column]
    private ?int $balance = 500;

    private Collection $IdTransaction;

    #[ORM\OneToMany(mappedBy: 'IdUser', targetEntity: Wallet::class)]
    private Collection $IdWalet;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $thumbnail = 'avatar.png';

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Transaction::class)]
    private Collection $transactions;

    #[ORM\OneToMany(mappedBy: 'userTo', targetEntity: Transaction::class)]
    private Collection $usersToTransaction;

    public function __construct()
    {
        $this->IdWalet = new ArrayCollection();
        $this->transactions = new ArrayCollection();
        $this->usersToTransaction = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        $roles[1]='ROLE_ADMIN';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCountryFrom(): ?string
    {
        return $this->countryFrom;
    }

    public function setCountryFrom(?string $countryFrom): static
    {
        $this->countryFrom = $countryFrom;

        return $this;
    }

    public function getCityFrom(): ?string
    {
        return $this->cityFrom;
    }

    public function setCityFrom(?string $cityFrom): static
    {
        $this->cityFrom = $cityFrom;

        return $this;
    }

    public function getDateBirth(): ?\DateTimeInterface
    {
        return $this->dateBirth;
    }

    public function setDateBirth(?\DateTimeInterface $dateBirth): static
    {
        $this->dateBirth = $dateBirth;

        return $this;
    }

    public function getCountryBirth(): ?string
    {
        return $this->countryBirth;
    }

    public function setCountryBirth(?string $countryBirth): static
    {
        $this->countryBirth = $countryBirth;

        return $this;
    }

    public function getCityBirth(): ?string
    {
        return $this->cityBirth;
    }

    public function setCityBirth(?string $cityBirth): static
    {
        $this->cityBirth = $cityBirth;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(?int $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getImageProfil(): ?string
    {
        return $this->imageProfil;
    }

    public function setImageProfil(?string $imageProfil): static
    {
        $this->imageProfil = $imageProfil;

        return $this;
    }

    public function getZipcode(): ?int
    {
        return $this->zipcode;
    }

    public function setZipcode(?int $zipcode): static
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getDateAT(): ?\DateTimeInterface
    {
        return $this->dateAT;
    }

    public function setDateAT(?\DateTimeInterface $dateAT): static
    {
        $this->dateAT = $dateAT;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getBalance(): ?int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): static
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * @return Collection<int, Wallet>
     */
    public function getIdWalet(): Collection
    {
        return $this->IdWalet;
    }

    public function addIdWalet(Wallet $idWalet): static
    {
        if (!$this->IdWalet->contains($idWalet)) {
            $this->IdWalet->add($idWalet);
            $idWalet->setIdUser($this);
        }

        return $this;
    }

    public function removeIdWalet(Wallet $idWalet): static
    {
        if ($this->IdWalet->removeElement($idWalet)) {
            // set the owning side to null (unless already changed)
            if ($idWalet->getIdUser() === $this) {
                $idWalet->setIdUser(null);
            }
        }

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail): static
    {
        $this->thumbnail = $thumbnail;

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
            $transaction->setUser($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getUser() === $this) {
                $transaction->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getUsersToTransaction(): Collection
    {
        return $this->usersToTransaction;
    }

    public function addUsersToTransaction(Transaction $usersToTransaction): static
    {
        if (!$this->usersToTransaction->contains($usersToTransaction)) {
            $this->usersToTransaction->add($usersToTransaction);
            $usersToTransaction->setUserTo($this);
        }

        return $this;
    }

    public function removeUsersToTransaction(Transaction $usersToTransaction): static
    {
        if ($this->usersToTransaction->removeElement($usersToTransaction)) {
            // set the owning side to null (unless already changed)
            if ($usersToTransaction->getUserTo() === $this) {
                $usersToTransaction->setUserTo(null);
            }
        }

        return $this;
    }
}
