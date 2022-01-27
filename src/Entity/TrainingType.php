<?php

namespace App\Entity;

use App\Repository\TrainingTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrainingTypeRepository::class)
 */
class TrainingType
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
     * @ORM\OneToMany(targetEntity=CallForTraining::class, mappedBy="training_type")
     */
    private $callForTrainings;

    public function __construct()
    {
        $this->callForTrainings = new ArrayCollection();
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

    public function __toString(): string
    {
        return  $this->name;
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

    /**
     * @return Collection|CallForTraining[]
     */
    public function getCallForTrainings(): Collection
    {
        return $this->callForTrainings;
    }

    public function addCallForTraining(CallForTraining $callForTraining): self
    {
        if (!$this->callForTrainings->contains($callForTraining)) {
            $this->callForTrainings[] = $callForTraining;
            $callForTraining->setTrainingType($this);
        }

        return $this;
    }

    public function removeCallForTraining(CallForTraining $callForTraining): self
    {
        if ($this->callForTrainings->removeElement($callForTraining)) {
            // set the owning side to null (unless already changed)
            if ($callForTraining->getTrainingType() === $this) {
                $callForTraining->setTrainingType(null);
            }
        }

        return $this;
    }
}
