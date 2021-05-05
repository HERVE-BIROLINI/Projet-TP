<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $Title;

    /**
     * @ORM\Column(type="text")
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Region;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Capacity;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2)
     */
    private $Price;

    /**
     * @ORM\Column(type="decimal", precision=2, scale=1)
     */
    private $Score;

    /**
     * ORM\Column(type="string", length=255)
     */
    // private $Image;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Category;

    /**
     * @ORM\OneToMany(targetEntity=Picture::class, mappedBy="article")
     */
    private $pictures;

    /**
     * @ORM\OneToMany(targetEntity=KartItem::class, mappedBy="article")
     */
    private $kartItems;

    public function __construct()
    {
        $this->kartItems = new ArrayCollection();
    }


    // public function __construct
    // ($Title,$Description,$Region,$Capacity,$Price,$Score,$Category,$Image){
        // $this->Title=$Title;
        // $this->Description=$Description;
        // $this->Region=$Region;
        // $this->Capacity=$Capacity;
        // $this->Price=$Price;
        // $this->Score=$Score;
        // $this->Category=$Category;
        // $this->pictures = new ArrayCollection();
        //
        // $this->Image=$Image;
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->Region;
    }

    public function setRegion(string $Region): self
    {
        $this->Region = $Region;

        return $this;
    }

    public function getCapacity(): ?string
    {
        return $this->Capacity;
    }

    public function setCapacity(string $Capacity): self
    {
        $this->Capacity = $Capacity;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->Price;
    }

    public function setPrice(string $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getScore(): ?string
    {
        return $this->Score;
    }

    public function setScore(string $Score): self
    {
        $this->Score = $Score;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }

    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setArticle($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getArticle() === $this) {
                $picture->setArticle(null);
            }
        }

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
            $kartItem->setArticle($this);
        }

        return $this;
    }

    public function removeKartItem(KartItem $kartItem): self
    {
        if ($this->kartItems->removeElement($kartItem)) {
            // set the owning side to null (unless already changed)
            if ($kartItem->getArticle() === $this) {
                $kartItem->setArticle(null);
            }
        }

        return $this;
    }

}