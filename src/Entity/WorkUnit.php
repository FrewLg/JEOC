<?php

namespace App\Entity;

use App\Repository\WorkUnitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WorkUnitRepository::class)
 */
class WorkUnit
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text",   nullable=true)
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
 
     

    public function __construct()
    {
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

   public function __toString(): string
    {
        return $this->name;
    }


    public function setName(string $name): self
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
 
}
