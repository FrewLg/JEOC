<?php

namespace App\Entity;

use App\Repository\CollegeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CollegeRepository::class)
 */
class College
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=CollegeCoordinator::class, mappedBy="college")
     */
    private $collegeCoordinators;

    /**
     * @ORM\OneToMany(targetEntity=Department::class, mappedBy="college")
     */
    private $departments;


    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $principal_contact;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $identification_code;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $mission;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $objective;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prefix;


    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;


    /**
     * @ORM\OneToMany(targetEntity=CallForTraining::class, mappedBy="college")
     */
    private $callForTrainings;

 

    

    public function __construct()
    {
        $this->collegeCoordinators = new ArrayCollection();
        $this->departments = new ArrayCollection();
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

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function __toString()
    {
        
   return $this->name;
    }
    
    /**
     * @return Collection|CollegeCoordinator[]
     */
    public function getCollegeCoordinators(): Collection
    {
        return $this->collegeCoordinators;
    }

    public function addCollegeCoordinator(CollegeCoordinator $collegeCoordinator): self
    {
        if (!$this->collegeCoordinators->contains($collegeCoordinator)) {
            $this->collegeCoordinators[] = $collegeCoordinator;
            $collegeCoordinator->setCollege($this);
        }

        return $this;
    }

    public function removeCollegeCoordinator(CollegeCoordinator $collegeCoordinator): self
    {
        if ($this->collegeCoordinators->removeElement($collegeCoordinator)) {
            // set the owning side to null (unless already changed)
            if ($collegeCoordinator->getCollege() === $this) {
                $collegeCoordinator->setCollege(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Department[]
     */
    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    public function addDepartment(Department $department): self
    {
        if (!$this->departments->contains($department)) {
            $this->departments[] = $department;
            $department->setCollege($this);
        }

        return $this;
    }

    public function removeDepartment(Department $department): self
    {
        if ($this->departments->removeElement($department)) {
            // set the owning side to null (unless already changed)
            if ($department->getCollege() === $this) {
                $department->setCollege(null);
            }
        }

        return $this;
    }
 


     
    public function getPrincipalContact(): ?string
    {
        return $this->principal_contact;
    }

    public function setPrincipalContact(?string $principal_contact): self
    {
        $this->principal_contact = $principal_contact;

        return $this;
    }

    public function getIdentificationCode(): ?string
    {
        return $this->identification_code;
    }

    public function setIdentificationCode(?string $identification_code): self
    {
        $this->identification_code = $identification_code;

        return $this;
    }

    public function getMission(): ?string
    {
        return $this->mission;
    }

    public function setMission(?string $mission): self
    {
        $this->mission = $mission;

        return $this;
    }

    public function getObjective(): ?string
    {
        return $this->objective;
    }

    public function setObjective(?string $objective): self
    {
        $this->objective = $objective;

        return $this;
    }


    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    public function setPrefix(?string $prefix): self
    {
        $this->prefix = $prefix;

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
            $callForTraining->setCollege($this);
        }

        return $this;
    }

    public function removeCallForTraining(CallForTraining $callForTraining): self
    {
        if ($this->callForTrainings->removeElement($callForTraining)) {
            // set the owning side to null (unless already changed)
            if ($callForTraining->getCollege() === $this) {
                $callForTraining->setCollege(null);
            }
        }

        return $this;
    }

     

  
}
