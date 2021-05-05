<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $lastname;

    /**
     * @ORM\Column(type="date")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasagreetoterms;

    /**
     * @ORM\Column(type="date")
     */
    private $inscriptiondate;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=0, nullable=true)
     */
    private $postalcode;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity=Kart::class, mappedBy="user", orphanRemoval=true)
     */
    private $karts;

    public function __construct()
    {
        $this->karts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
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

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getHasagreetoterms(): ?bool
    {
        return $this->hasagreetoterms;
    }

    public function setHasagreetoterms(bool $hasagreetoterms): self
    {
        $this->hasagreetoterms = $hasagreetoterms;

        return $this;
    }

    public function getInscriptiondate(): ?\DateTimeInterface
    {
        return $this->inscriptiondate;
    }

    public function setInscriptiondate(\DateTimeInterface $inscriptiondate): self
    {
        $this->inscriptiondate = $inscriptiondate;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalcode(): ?string
    {
        return $this->postalcode;
    }

    public function setPostalcode(?string $postalcode): self
    {
        $this->postalcode = $postalcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection|Kart[]
     */
    public function getKarts(): Collection
    {
        return $this->karts;
    }

    public function addKart(Kart $kart): self
    {
        if (!$this->karts->contains($kart)) {
            $this->karts[] = $kart;
            $kart->setUser($this);
        }

        return $this;
    }

    public function removeKart(Kart $kart): self
    {
        if ($this->karts->removeElement($kart)) {
            // set the owning side to null (unless already changed)
            if ($kart->getUser() === $this) {
                $kart->setUser(null);
            }
        }

        return $this;
    }
}
