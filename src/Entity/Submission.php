<?php

namespace App\Entity;

use App\Repository\SubmissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=SubmissionRepository::class)
  *
 */
class Submission
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

 
 

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $abstract;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="submissions")
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sub_title;

    // /**
    //  * @ORM\Column(type="boolean", nullable=true)
    //  */
    // private $agree_to_the_terms;  
 
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $round;

     
 
    /**
     * @ORM\ManyToOne(targetEntity=CallForProposal::class, inversedBy="submissions")
     */
    private $callForProposal;

    /**
     * @ORM\OneToMany(targetEntity=CoAuthor::class, mappedBy="submission" , orphanRemoval=true,cascade={"persist"})
     */
  #  private $coAuthors; 

       protected $coAuthors;
       
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $sent_at;

    /**
     * @ORM\Column(type="text",   nullable=true)
     
     */
    private $research_outcome;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $uidentifier;

    /**
     * @ORM\ManyToOne(targetEntity=ThematicArea::class, inversedBy="submissions")
     */
    private $thematic_area;

    /**
     * @ORM\OneToMany(targetEntity=ReviewAssignment::class, mappedBy="submission" , orphanRemoval=true,cascade={"persist"})
     */
    private $reviewAssignments;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $complete;

    /**
     * @ORM\Column(type="text",  nullable=true)
     */
    private $background_and_rationale;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $submission_type;

    /**
     * @ORM\Column(type="text",  nullable=true)
     */
    private $methodology;
    
       /**
     * @ORM\Column(type="text",  nullable=true)
     */
    private $reference;
    
  
 
    /**
     * @ORM\Column(type="text",  nullable=true)
     */
    private $GeneralObjective;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $funding_organization;

    /**
     * @ORM\OneToMany(targetEntity=CollaboratingInstitution::class, mappedBy="submission" , orphanRemoval=true,cascade={"persist"})
     */
    private $collaboratingInstitutions;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $project_start_at;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $project_end_at;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $progress;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_author_pi;

    /**
     * @ORM\OneToMany(targetEntity=EditorialDecision::class, mappedBy="submission" , orphanRemoval=true,cascade={"persist"})
     */
    private $editorialDecisions;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $copyedit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $terminalreport;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $published;

    /**
     * @ORM\OneToMany(targetEntity=FundingInstition::class, mappedBy="submission")
     */
    private $fundingInstitions;

    // /**
    //  * @ORM\OneToMany(targetEntity=PublishedSubmission::class, mappedBy="submission")
    //  */
    // private $publishedSubmissions;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    // /**
    //  * @ORM\OneToOne(targetEntity=Review::class, inversedBy="submission", cascade={"persist", "remove"})
    //  * @ORM\JoinColumn(nullable=false)
    //  */
    // private $review;
     
      /**
     * @ORM\OneToMany(targetEntity=SubmissionBudget::class, mappedBy="submission", orphanRemoval=true,cascade={"persist"})
     */
    private $submissionBudgets;
   /**
    * @ORM\OneToMany(targetEntity=ResearchTimeTable::class, mappedBy="submission", orphanRemoval=true,cascade={"persist"})
    */
   private $researchTimeTables;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $keywords;

    /**
     * @ORM\OneToMany(targetEntity=SubmissionAttachement::class, mappedBy="submission" , orphanRemoval=true,cascade={"persist"})
     */
    private $submissionAttachements;

    /**
     * @ORM\Column(type="integer")
     */
    private $step=0;

    /**
     * @ORM\OneToMany(targetEntity=SpecificObjective::class, mappedBy="submission" , orphanRemoval=true,cascade={"persist"})
     */
    private $specificObjectives;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="submission" , orphanRemoval=true,cascade={"persist"})
     */
    private $reviews;

    /**
     * @ORM\OneToOne(targetEntity=PublishedResearch::class, mappedBy="submission", cascade={"persist", "remove"})
     */
    private $publishedResearch;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $budget_and_time_schedule;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $actionplan;

    /**
     * @ORM\OneToMany(targetEntity=ResearchReport::class, mappedBy="submission", orphanRemoval=true)
     */
    private $researchReports;

    /**
     * @ORM\OneToMany(targetEntity=ResearchReportSubmissionSetting::class, mappedBy="submission", orphanRemoval=true)
     */
    private $researchReportSubmissionSettings;
    /*
    * @ORM\Column(type="boolean", nullable=true)
     */
    private $granted;

   

 
 
    public function __construct()
    {
 
        $this->coAuthors = new ArrayCollection();
        $this->reviewAssignments = new ArrayCollection(); 
        $this->collaboratingInstitutions = new ArrayCollection();
        $this->editorialDecisions = new ArrayCollection();
        $this->fundingInstitions = new ArrayCollection();
        // $this->publishedSubmissions = new ArrayCollection();
        $this->submissionBudgets = new ArrayCollection();
        $this->researchTimeTables = new ArrayCollection();
        $this->submissionAttachements = new ArrayCollection();
        $this->specificObjectives = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->researchReports = new ArrayCollection();
        $this->researchReportSubmissionSettings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

 
   
    // public function getReview(): ?Review
    // {
    //     return $this->review;
    // }

    // public function setReview(Review $review): self
    // {
    //     $this->review = $review;

    //     return $this;
    // }

    
   
        public function __toString(): string
    {
        return $this->id;
    }

    public function getAbstract(): ?string
    {
        return $this->abstract;
    }

    public function setAbstract(?string $abstract): self
    {
        $this->abstract = $abstract;

        return $this;
    }

    public function getActionplan(): ?string
    {
        return $this->actionplan;
    }

    public function setActionplan(?string $actionplan): self
    {
        $this->actionplan = $actionplan;

        return $this;
    }
    
    
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getSubTitle(): ?string
    {
        return $this->sub_title;
    }

    public function setSubTitle(?string $sub_title): self
    {
        $this->sub_title = $sub_title;

        return $this;
    }

    // public function getAgreeToTheTerms(): ?bool
    // {
    //     return $this->agree_to_the_terms;
    // }

    // public function setAgreeToTheTerms(bool $agree_to_the_terms): self
    // {
    //     $this->agree_to_the_terms = $agree_to_the_terms;

    //     return $this;
    // }

 
   

    public function getRound(): ?string
    {
        return $this->round;
    }

    public function setRound(?string $round): self
    {
        $this->round = $round;

        return $this;
    }

    
   

    public function getCallForProposal(): ?CallForProposal
    {
        return $this->callForProposal;
    }

    public function setCallForProposal(?CallForProposal $callForProposal): self
    {
        $this->callForProposal = $callForProposal;

        return $this;
    }

    /**
     * @return Collection|CoAuthor[]
     */
    public function getCoAuthors(): Collection
    {
        return $this->coAuthors;
    }

    public function addCoAuthor(CoAuthor $coAuthor): self
    {
        if (!$this->coAuthors->contains($coAuthor)) {
            $this->coAuthors[] = $coAuthor;
            $coAuthor->setSubmission($this);
        }

        return $this;
    }

    public function removeCoAuthor(CoAuthor $coAuthor): self
    {
        if ($this->coAuthors->removeElement($coAuthor)) {
        
        
            if ($coAuthor->getSubmission() === $this) {
                $coAuthor->setSubmission(null);
            }
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSentAt(): ?\DateTimeInterface
    {
        return $this->sent_at;
    }

    public function setSentAt(?\DateTimeInterface $sent_at): self
    {
        $this->sent_at = $sent_at;

        return $this;
    }

    public function getResearchOutcome() 
    {
        return $this->research_outcome;
    }

    public function setResearchOutcome($research_outcome): self
    {
        $this->research_outcome = $research_outcome;

        return $this;
    }

    public function getUidentifier(): ?string
    {
        return $this->uidentifier;
    }

    public function setUidentifier(?string $uidentifier): self
    {
        $this->uidentifier = $uidentifier;

        return $this;
    }

    public function getThematicArea(): ?ThematicArea
    {
        return $this->thematic_area;
    }


    public function setThematicArea(?ThematicArea $thematic_area): self
    {
        $this->thematic_area = $thematic_area;

        return $this;
    }

    /**
     * @return Collection|ReviewAssignment[]
     */
    public function getReviewAssignments(): Collection
    {
        return $this->reviewAssignments;
    }

    public function addReviewAssignment(ReviewAssignment $reviewAssignment): self
    {
        if (!$this->reviewAssignments->contains($reviewAssignment)) {
            $this->reviewAssignments[] = $reviewAssignment;
            $reviewAssignment->setSubmission($this);
        }

        return $this;
    }

    public function removeReviewAssignment(ReviewAssignment $reviewAssignment): self
    {
        if ($this->reviewAssignments->removeElement($reviewAssignment)) {
            // set the owning side to null (unless already changed)
            if ($reviewAssignment->getSubmission() === $this) {
                $reviewAssignment->setSubmission(null);
            }
        }

        return $this;
    }

    public function getComplete(): ?string
    {
        return $this->complete;
    }

    public function setComplete(?string $complete): self
    {
        $this->complete = $complete;

        return $this;
    }
    public function getBackgroundAndRationale(): ?string
    {
        return $this->background_and_rationale;
    }

    public function setBackgroundAndRationale(?string $background_and_rationale): self
    {
        $this->background_and_rationale = $background_and_rationale;

        return $this;
    }
    
     
    public function getMethodology(): ?string
    {
        return $this->methodology;
    }

    public function setMethodology(?string $methodology): self
    {
        $this->methodology = $methodology;

        return $this;
    }
    
    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }
    public function getSubmissionType(): ?string
    {
        return $this->submission_type;
    }

    public function setSubmissionType(?string $submission_type): self
    {
        $this->submission_type = $submission_type;

        return $this;
    }
 

    

    public function getGeneralObjective(): ?string
    {
        return $this->GeneralObjective;
    }

    public function setGeneralObjective(?string $GeneralObjective): self
    {
        $this->GeneralObjective = $GeneralObjective;

        return $this;
    }

    public function getFundingOrganization(): ?string
    {
        return $this->funding_organization;
    }

    public function setFundingOrganization(?string $funding_organization): self
    {
        $this->funding_organization = $funding_organization;

        return $this;
    }

    /**
     * @return Collection|CollaboratingInstitution[]
     */
    public function getCollaboratingInstitutions(): Collection
    {
        return $this->collaboratingInstitutions;
    }

    public function addCollaboratingInstitution(CollaboratingInstitution $collaboratingInstitution): self
    {
        if (!$this->collaboratingInstitutions->contains($collaboratingInstitution)) {
            $this->collaboratingInstitutions[] = $collaboratingInstitution;
            $collaboratingInstitution->setSubmission($this);
        }

        return $this;
    }

    public function removeCollaboratingInstitution(CollaboratingInstitution $collaboratingInstitution): self
    {
        if ($this->collaboratingInstitutions->removeElement($collaboratingInstitution)) {
            // set the owning side to null (unless already changed)
            if ($collaboratingInstitution->getSubmission() === $this) {
                $collaboratingInstitution->setSubmission(null);
            }
        }

        return $this;
    }

    public function getProjectStartAt(): ?\DateTimeInterface
    {
        return $this->project_start_at;
    }

    public function setProjectStartAt(?\DateTimeInterface $project_start_at): self
    {
        $this->project_start_at = $project_start_at;

        return $this;
    }

    public function getProjectEndAt(): ?\DateTimeInterface
    {
        return $this->project_end_at;
    }

    public function setProjectEndAt(?\DateTimeInterface $project_end_at): self
    {
        $this->project_end_at = $project_end_at;

        return $this;
    }

    public function getProgress(): ?int
    {
        return $this->progress;
    }

    public function setProgress(?int $progress): self
    {
        $this->progress = $progress;

        return $this;
    }

    public function getIsAuthorPi(): ?bool
    {
        return $this->is_author_pi;
    }

    public function setIsAuthorPi(?bool $is_author_pi): self
    {
        $this->is_author_pi = $is_author_pi;

        return $this;
    }

    /**
     * @return Collection|EditorialDecision[]
     */
    public function getEditorialDecisions(): Collection
    {
        return $this->editorialDecisions;
    }

    public function addEditorialDecision(EditorialDecision $editorialDecision): self
    {
        if (!$this->editorialDecisions->contains($editorialDecision)) {
            $this->editorialDecisions[] = $editorialDecision;
            $editorialDecision->setSubmission($this);
        }

        return $this;
    }

    public function removeEditorialDecision(EditorialDecision $editorialDecision): self
    {
        if ($this->editorialDecisions->removeElement($editorialDecision)) {
            // set the owning side to null (unless already changed)
            if ($editorialDecision->getSubmission() === $this) {
                $editorialDecision->setSubmission(null);
            }
        }

        return $this;
    }

    public function getCopyedit(): ?string
    {
        return $this->copyedit;
    }

    public function setCopyedit(?string $copyedit): self
    {
        $this->copyedit = $copyedit;

        return $this;
    }

    public function getTerminalreport(): ?string
    {
        return $this->terminalreport;
    }

    public function setTerminalreport(?string $terminalreport): self
    {
        $this->terminalreport = $terminalreport;

        return $this;
    }

    public function getPublished(): ?string
    {
        return $this->published;
    }

    public function setPublished(?string $published): self
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return Collection|FundingInstition[]
     */
    public function getFundingInstitions(): Collection
    {
        return $this->fundingInstitions;
    }

    public function addFundingInstition(FundingInstition $fundingInstition): self
    {
        if (!$this->fundingInstitions->contains($fundingInstition)) {
            $this->fundingInstitions[] = $fundingInstition;
            $fundingInstition->setSubmission($this);
        }

        return $this;
    }

    public function removeFundingInstition(FundingInstition $fundingInstition): self
    {
        if ($this->fundingInstitions->removeElement($fundingInstition)) {
            // set the owning side to null (unless already changed)
            if ($fundingInstition->getSubmission() === $this) {
                $fundingInstition->setSubmission(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PublishedSubmission[]
     */
    public function getPublishedSubmissions(): Collection
    {
        return $this->publishedSubmissions;
    }

    public function addPublishedSubmission(PublishedSubmission $publishedSubmission): self
    {
        if (!$this->publishedSubmissions->contains($publishedSubmission)) {
            $this->publishedSubmissions[] = $publishedSubmission;
            $publishedSubmission->setSubmission($this);
        }

        return $this;
    }

    public function removePublishedSubmission(PublishedSubmission $publishedSubmission): self
    {
        if ($this->publishedSubmissions->removeElement($publishedSubmission)) {
            // set the owning side to null (unless already changed)
            if ($publishedSubmission->getSubmission() === $this) {
                $publishedSubmission->setSubmission(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|SubmissionBudget[]
     */
    public function getSubmissionBudgets(): Collection
    {
        return $this->submissionBudgets;
    }

    public function addSubmissionBudget(SubmissionBudget $submissionBudget): self
    {
        if (!$this->submissionBudgets->contains($submissionBudget)) {
            $this->submissionBudgets[] = $submissionBudget;
            $submissionBudget->setSubmission($this);
        }

        return $this;
    }

    public function removeSubmissionBudget(SubmissionBudget $submissionBudget): self
    {
        if ($this->submissionBudgets->removeElement($submissionBudget)) {
            // set the owning side to null (unless already changed)
            if ($submissionBudget->getSubmission() === $this) {
                $submissionBudget->setSubmission(null);
            }
        }

        return $this;
    }


     /**
     * @return Collection|ResearchTimeTable[]
     */
    public function getResearchTimeTables(): Collection
    {
        return $this->researchTimeTables;
    }

    public function addResearchTimeTable(ResearchTimeTable $researchTimeTable): self
    {
        if (!$this->researchTimeTables->contains($researchTimeTable)) {
            $this->researchTimeTables[] = $researchTimeTable;
            $researchTimeTable->setSubmission($this);
        }

        return $this;
    }

    public function removeResearchTimeTable(ResearchTimeTable $researchTimeTable): self
    {
        if ($this->researchTimeTables->removeElement($researchTimeTable)) {
            // set the owning side to null (unless already changed)
            if ($researchTimeTable->getSubmission() === $this) {
                $researchTimeTable->setSubmission(null);
            }
        }

        return $this;
    }


    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(?string $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * @return Collection|SubmissionAttachement[]
     */
    public function getSubmissionAttachements(): Collection
    {
        return $this->submissionAttachements;
    }

    public function addSubmissionAttachement(SubmissionAttachement $submissionAttachement): self
    {
        if (!$this->submissionAttachements->contains($submissionAttachement)) {
            $this->submissionAttachements[] = $submissionAttachement;
            $submissionAttachement->setSubmission($this);
        }

        return $this;
    }

    public function removeSubmissionAttachement(SubmissionAttachement $submissionAttachement): self
    {
        if ($this->submissionAttachements->removeElement($submissionAttachement)) {
            // set the owning side to null (unless already changed)
            if ($submissionAttachement->getSubmission() === $this) {
                $submissionAttachement->setSubmission(null);
            }
        }

        return $this;
    }

    public function getStep(): ?int
    {
        return $this->step;
    }

    public function setStep(int $step): self
    {
        $this->step = $step;

        return $this;
    }

    /**
     * @return Collection|SpecificObjective[]
     */
    public function getSpecificObjectives(): Collection
    {
        return $this->specificObjectives;
    }

    public function addSpecificObjective(SpecificObjective $specificObjective): self
    {
        if (!$this->specificObjectives->contains($specificObjective)) {
            $this->specificObjectives[] = $specificObjective;
            $specificObjective->setSubmission($this);
        }

        return $this;
    }

    public function removeSpecificObjective(SpecificObjective $specificObjective): self
    {
        if ($this->specificObjectives->removeElement($specificObjective)) {
            // set the owning side to null (unless already changed)
            if ($specificObjective->getSubmission() === $this) {
                $specificObjective->setSubmission(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setSubmission($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getSubmission() === $this) {
                $review->setSubmission(null);
            }
        }

        return $this;
    }

    public function getPublishedResearch(): ?PublishedResearch
    {
        return $this->publishedResearch;
    }

    public function setPublishedResearch(?PublishedResearch $publishedResearch): self
    {
        // unset the owning side of the relation if necessary
        if ($publishedResearch === null && $this->publishedResearch !== null) {
            $this->publishedResearch->setSubmission(null);
        }

        // set the owning side of the relation if necessary
        if ($publishedResearch !== null && $publishedResearch->getSubmission() !== $this) {
            $publishedResearch->setSubmission($this);
        }

        $this->publishedResearch = $publishedResearch;

        return $this;
    }

    public function getBudgetAndTimeSchedule(): ?string
    {
        return $this->budget_and_time_schedule;
    }

    public function setBudgetAndTimeSchedule(?string $budget_and_time_schedule): self
    {
        $this->budget_and_time_schedule = $budget_and_time_schedule;

        return $this;
    }

    /**
     * @return Collection|ResearchReport[]
     */
    public function getResearchReports(): Collection
    {
        return $this->researchReports;
    }

    public function addResearchReport(ResearchReport $researchReport): self
    {
        if (!$this->researchReports->contains($researchReport)) {
            $this->researchReports[] = $researchReport;
            $researchReport->setSubmission($this);
        }

        return $this;
    }

    public function removeResearchReport(ResearchReport $researchReport): self
    {
        if ($this->researchReports->removeElement($researchReport)) {
            // set the owning side to null (unless already changed)
            if ($researchReport->getSubmission() === $this) {
                $researchReport->setSubmission(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ResearchReportSubmissionSetting[]
     */
    public function getResearchReportSubmissionSettings(): Collection
    {
        return $this->researchReportSubmissionSettings;
    }

    public function addResearchReportSubmissionSetting(ResearchReportSubmissionSetting $researchReportSubmissionSetting): self
    {
        if (!$this->researchReportSubmissionSettings->contains($researchReportSubmissionSetting)) {
            $this->researchReportSubmissionSettings[] = $researchReportSubmissionSetting;
            $researchReportSubmissionSetting->setSubmission($this);
        }

        return $this;
    }

    public function removeResearchReportSubmissionSetting(ResearchReportSubmissionSetting $researchReportSubmissionSetting): self
    {
        if ($this->researchReportSubmissionSettings->removeElement($researchReportSubmissionSetting)) {
            // set the owning side to null (unless already changed)
            if ($researchReportSubmissionSetting->getSubmission() === $this) {
                $researchReportSubmissionSetting->setSubmission(null);
            }
        }
    return $this;
    }
    public function getGranted(): ?bool
    {
        return $this->granted;
    }

    public function setGranted(?bool $granted): self
    {
        $this->granted = $granted;

        return $this;
    }

    

    
}
