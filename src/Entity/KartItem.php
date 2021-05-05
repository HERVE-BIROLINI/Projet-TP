<?php

namespace App\Entity;

use App\Repository\KartItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KartItemRepository::class)
 * ORM\Table(name="")
 */
class KartItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * ORM\Column(name="")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="kartItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=Kart::class, inversedBy="kartItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $kart;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getKart(): ?Kart
    {
        return $this->kart;
    }

    public function setKart(?Kart $kart): self
    {
        $this->kart = $kart;

        return $this;
    }
}
