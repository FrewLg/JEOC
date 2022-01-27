<?php

namespace App\Entity;

use App\Repository\PublishedTopicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PublishedTopicRepository::class)
 */
class PublishedTopic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $budget;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $year;

    /**
     * @ORM\OneToMany(targetEntity=PublishedResearch::class, mappedBy="title", orphanRemoval=true)
     */
    private $title;

    public function __construct()
    {
        $this->title = new ArrayCollection();
    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function __toString()
    {
        
  
    
        return $this->getName();
     
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBudget(): ?string
    {
        return $this->budget;
    }

    public function setBudget(?string $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getYear(): ?\DateTimeInterface
    {
        return $this->year;
    }

    public function setYear(?\DateTimeInterface $year): self
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return Collection|PublishedResearch[]
     */
    public function getTitle(): Collection
    {
        return $this->title;
    }

    public function addTitle(PublishedResearch $title): self
    {
        if (!$this->title->contains($title)) {
            $this->title[] = $title;
            $title->setTitle($this);
        }

        return $this;
    }

    public function removeTitle(PublishedResearch $title): self
    {
        if ($this->title->removeElement($title)) {
            // set the owning side to null (unless already changed)
            if ($title->getTitle() === $this) {
                $title->setTitle(null);
            }
        }

        return $this;
    }

    
   
}
