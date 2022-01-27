<?php

namespace App\Entity;

use App\Repository\ThematicAreaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ThematicAreaRepository::class)
 */
class ThematicArea
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=WorkUnit::class, inversedBy="thematicAreas")
     */
    private $work_unit;

    /**
     * @ORM\OneToMany(targetEntity=Submission::class, mappedBy="thematic_area")
     */
    private $submissions;

    /**
     * @ORM\ManyToOne(targetEntity=College::class, inversedBy="thematicAreas")
     */
    private $college;

    public function __construct()
    {
        $this->submissions = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getWorkUnit(): ?WorkUnit
    {
        return $this->work_unit;
    }

    public function setWorkUnit(?WorkUnit $work_unit): self
    {
        $this->work_unit = $work_unit;

        return $this;
    }

    /**
     * @return Collection|Submission[]
     */
    public function getSubmissions(): Collection
    {
        return $this->submissions;
    }

    public function addSubmission(Submission $submission): self
    {
        if (!$this->submissions->contains($submission)) {
            $this->submissions[] = $submission;
            $submission->setThematicArea($this);
        }

        return $this;
    }
  
    
       function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getName();
    }  
    
    
    public function removeSubmission(Submission $submission): self
    {
        if ($this->submissions->removeElement($submission)) {
            // set the owning side to null (unless already changed)
            if ($submission->getThematicArea() === $this) {
                $submission->setThematicArea(null);
            }
        }

        return $this;
    }

    public function getCollege(): ?College
    {
        return $this->college;
    }

    public function setCollege(?College $college): self
    {
        $this->college = $college;

        return $this;
    }
}
