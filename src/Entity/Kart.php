<?php

namespace App\Entity;

use App\Repository\KartRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KartRepository::class)
 */
class Kart
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationdate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="karts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=KartItem::class, mappedBy="kart")
     */
    private $kartItems;

    // public function __construct()
    // {
        // $this->setUser;
        // $this->setCreationdate(new DateTime());
        // $this->setUser;
        // $this->articles = new ArrayCollection();
        // $this->kartItems = new ArrayCollection();
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreationdate(): ?\DateTimeInterface
    {
        return $this->creationdate;
    }

    public function setCreationdate(\DateTimeInterface $creationdate): self
    {
        $this->creationdate = $creationdate;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|KartItem[]
     */
    public function getKartItems(): Collection
    {
        return $this->kartItems;
    }

    public function addKartItem(KartItem $kartItem): self
    {
        if (!$this->kartItems->contains($kartItem)) {
            $this->kartItems[] = $kartItem;
            $kartItem->setKart($this);
        }

        return $this;
    }

    public function removeKartItem(KartItem $kartItem): self
    {
        if ($this->kartItems->removeElement($kartItem)) {
            // set the owning side to null (unless already changed)
            if ($kartItem->getKart() === $this) {
                $kartItem->setKart(null);
            }
        }

        return $this;
    }

}
