<?php

namespace App\Entity;

use App\Repository\PictureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PictureRepository::class)
 */
class Picture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pathname;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="pictures")
     */
    private $article;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPathname(): ?string
    {
        return $this->pathname;
    }

    public function setPathname(string $pathname): self
    {
        $this->pathname = $pathname;

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
}
