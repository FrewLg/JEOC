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
     * @ORM\OneToMany(targetEntity=Submission::class, mappedBy="workunit")
     */
    private $submissions;

    /**
     * @ORM\OneToMany(targetEntity=Guidelines::class, mappedBy="work_unit")
     */
    private $guidelines;

 
    /**
     * @ORM\OneToMany(targetEntity=ThematicArea::class, mappedBy="work_unit")
     */
    private $thematicAreas;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prefix;
 
    /**
     * @ORM\OneToMany(targetEntity=InstitutionalReviewersBoard::class, mappedBy="workunit")
     */
    private $institutionalReviewersBoards;

    /**
     * @ORM\OneToMany(targetEntity=GuidelineForReviewer::class, mappedBy="workunit")
     */
    private $guidelineForReviewers;

    public function __construct()
    {
        $this->submissions = new ArrayCollection();
        $this->guidelines = new ArrayCollection();
        $this->callForProposals = new ArrayCollection();
        $this->thematicAreas = new ArrayCollection();
        $this->institutionalReviewersBoards = new ArrayCollection();
        $this->guidelineForReviewers = new ArrayCollection();
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
            $submission->setWorkunit($this);
        }

        return $this;
    }

    public function removeSubmission(Submission $submission): self
    {
        if ($this->submissions->removeElement($submission)) {
            // set the owning side to null (unless already changed)
            if ($submission->getWorkunit() === $this) {
                $submission->setWorkunit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Guidelines[]
     */
    public function getGuidelines(): Collection
    {
        return $this->guidelines;
    }

    public function addGuideline(Guidelines $guideline): self
    {
        if (!$this->guidelines->contains($guideline)) {
            $this->guidelines[] = $guideline;
            $guideline->setWorkUnit($this);
        }

        return $this;
    }

    public function removeGuideline(Guidelines $guideline): self
    {
        if ($this->guidelines->removeElement($guideline)) {
            // set the owning side to null (unless already changed)
            if ($guideline->getWorkUnit() === $this) {
                $guideline->setWorkUnit(null);
            }
        }

        return $this;
    }

    
    /**
     * @return Collection|ThematicArea[]
     */
    public function getThematicAreas(): Collection
    {
        return $this->thematicAreas;
    }

    public function addThematicArea(ThematicArea $thematicArea): self
    {
        if (!$this->thematicAreas->contains($thematicArea)) {
            $this->thematicAreas[] = $thematicArea;
            $thematicArea->setWorkUnit($this);
        }

        return $this;
    }

    public function removeThematicArea(ThematicArea $thematicArea): self
    {
        if ($this->thematicAreas->removeElement($thematicArea)) {
            // set the owning side to null (unless already changed)
            if ($thematicArea->getWorkUnit() === $this) {
                $thematicArea->setWorkUnit(null);
            }
        }

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

    /**
     * @return Collection|InstitutionalReviewersBoard[]
     */
    public function getInstitutionalReviewersBoards(): Collection
    {
        return $this->institutionalReviewersBoards;
    }

    public function addInstitutionalReviewersBoard(InstitutionalReviewersBoard $institutionalReviewersBoard): self
    {
        if (!$this->institutionalReviewersBoards->contains($institutionalReviewersBoard)) {
            $this->institutionalReviewersBoards[] = $institutionalReviewersBoard;
            $institutionalReviewersBoard->setWorkunit($this);
        }

        return $this;
    }

    public function removeInstitutionalReviewersBoard(InstitutionalReviewersBoard $institutionalReviewersBoard): self
    {
        if ($this->institutionalReviewersBoards->removeElement($institutionalReviewersBoard)) {
            // set the owning side to null (unless already changed)
            if ($institutionalReviewersBoard->getWorkunit() === $this) {
                $institutionalReviewersBoard->setWorkunit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|GuidelineForReviewer[]
     */
    public function getGuidelineForReviewers(): Collection
    {
        return $this->guidelineForReviewers;
    }

    public function addGuidelineForReviewer(GuidelineForReviewer $guidelineForReviewer): self
    {
        if (!$this->guidelineForReviewers->contains($guidelineForReviewer)) {
            $this->guidelineForReviewers[] = $guidelineForReviewer;
            $guidelineForReviewer->setWorkunit($this);
        }

        return $this;
    }

    public function removeGuidelineForReviewer(GuidelineForReviewer $guidelineForReviewer): self
    {
        if ($this->guidelineForReviewers->removeElement($guidelineForReviewer)) {
            // set the owning side to null (unless already changed)
            if ($guidelineForReviewer->getWorkunit() === $this) {
                $guidelineForReviewer->setWorkunit(null);
            }
        }

        return $this;
    }
}
