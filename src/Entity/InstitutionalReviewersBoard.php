<?php

namespace App\Entity;

use App\Repository\InstitutionalReviewersBoardRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InstitutionalReviewersBoardRepository::class)
 */
class InstitutionalReviewersBoard
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="institutionalReviewersBoards")
     */
    private $reviewer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $specialization;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $affiliation;

    /**
     * @ORM\ManyToOne(targetEntity=WorkUnit::class, inversedBy="institutionalReviewersBoards")
     */
    private $workunit;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="i_r_b_member")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=College::class, inversedBy="institutionalReviewersBoards")
     */
    private $college;

    public function __toString(): string
    {
        return  $this->name.''.$this->id;
     #           return $this->User . "/" . $this->name;
#    return $this->name->getName();
    #. "/" .$this->AssetGroup. "/" . $this->name;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReviewer(): ?User
    {
        return $this->reviewer;
    }

    public function setReviewer(?User $reviewer): self
    {
        $this->reviewer = $reviewer;

        return $this;
    }

    public function getSpecialization(): ?string
    {
        return $this->specialization;
    }

    public function setSpecialization(?string $specialization): self
    {
        $this->specialization = $specialization;

        return $this;
    }

    public function getAffiliation(): ?string
    {
        return $this->affiliation;
    }

    public function setAffiliation(?string $affiliation): self
    {
        $this->affiliation = $affiliation;

        return $this;
    }

    public function getWorkunit(): ?WorkUnit
    {
        return $this->workunit;
    }

    public function setWorkunit(?WorkUnit $workunit): self
    {
        $this->workunit = $workunit;

        return $this;
    }

    public function getName(): ?User
    {
        return $this->name;
    }

    public function setName(?User $name): self
    {
        $this->name = $name;

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
