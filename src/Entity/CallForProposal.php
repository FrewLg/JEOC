<?php

namespace App\Entity;

use App\Repository\CallForProposalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CallForProposalRepository::class)
 */
class CallForProposal
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
    private $guidelines;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deadline;

    /**
     * @ORM\Column(type="text",  nullable=true)
     */
    private $subject;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $post_date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_date;

    // /**
    //  * @ORM\OneToMany(targetEntity=Submission::class, mappedBy="callForProposal")
    //  */
    // private $submissions;

    /**
     * @ORM\ManyToOne(targetEntity=ThematicArea::class, inversedBy="callForProposals")
     */
    private $thematic_area;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $research_type;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $heading;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $uidentifier;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $number_of_co_pi;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $allow_non_academic_staff_as_pi;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $allow_researcher_from_another_college;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $allow_pi_from_other_university;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $funding_source;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $commitment_from_other_research;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $review_process_start;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $review_process_end;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $reviewers_decision_will_be_communicated_at;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $project_starts_on;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $views;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $approved;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="callForProposals")
     */
    private $approved_by;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $approved_at;

    /**
     * @ORM\ManyToOne(targetEntity=College::class, inversedBy="callForProposals")
     */
    private $college;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_call_from_center;
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ResearchReportPhase", mappedBy="applicationCall")
     */
    private $researchReportPhase;

 

    public function __construct()
    {
        $this->submissions = new ArrayCollection();
        // $this->college = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        
   return $this->subject;
    }
    
 

    public function getGuidelines(): ?string
    {
        return $this->guidelines;
    }

    public function setGuidelines(?string $guidelines): self
    {
        $this->guidelines = $guidelines;

        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(?\DateTimeInterface $deadline): self
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getPostDate(): ?\DateTimeInterface
    {
        return $this->post_date;
    }

    public function setPostDate(?\DateTimeInterface $post_date): self
    {
        $this->post_date = $post_date;

        return $this;
    }

    public function getUpdatedDate(): ?\DateTimeInterface
    {
        return $this->updated_date;
    }

    public function setUpdatedDate(?\DateTimeInterface $updated_date): self
    {
        $this->updated_date = $updated_date;

        return $this;
    }

   
    public function getThematicArea(): ?ThematicArea
    {
        return $this->thematic_area;
    }

    public function setThematicArea(ThematicArea $thematic_area): self
    {
        $this->thematic_area = $thematic_area;

        return $this;
    }

 
 
    
    public function getResearchType(): ?string
    {
        return $this->research_type;
    }

    public function setResearchType(?string $research_type): self
    {
        $this->research_type = $research_type;

        return $this;
    }

    public function getHeading(): ?string
    {
        return $this->heading;
    }

    public function setHeading(?string $heading): self
    {
        $this->heading = $heading;

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

    public function getNumberOfCoPi(): ?int
    {
        return $this->number_of_co_pi;
    }

    public function setNumberOfCoPi(?int $number_of_co_pi): self
    {
        $this->number_of_co_pi = $number_of_co_pi;

        return $this;
    }

    public function getAllowNonAcademicStaffAsPi(): ?bool
    {
        return $this->allow_non_academic_staff_as_pi;
    }

    public function setAllowNonAcademicStaffAsPi(?bool $allow_non_academic_staff_as_pi): self
    {
        $this->allow_non_academic_staff_as_pi = $allow_non_academic_staff_as_pi;

        return $this;
    }

    public function getAllowResearcherFromAnotherCollege(): ?bool
    {
        return $this->allow_researcher_from_another_college;
    }

    public function setAllowResearcherFromAnotherCollege(?bool $allow_researcher_from_another_college): self
    {
        $this->allow_researcher_from_another_college = $allow_researcher_from_another_college;

        return $this;
    }

    public function getAllowPiFromOtherUniversity(): ?bool
    {
        return $this->allow_pi_from_other_university;
    }

    public function setAllowPiFromOtherUniversity(?bool $allow_pi_from_other_university): self
    {
        $this->allow_pi_from_other_university = $allow_pi_from_other_university;

        return $this;
    }

    public function getFundingSource(): ?string
    {
        return $this->funding_source;
    }

    public function setFundingSource(?string $funding_source): self
    {
        $this->funding_source = $funding_source;

        return $this;
    }

    public function getCommitmentFromOtherResearch(): ?bool
    {
        return $this->commitment_from_other_research;
    }

    public function setCommitmentFromOtherResearch(?bool $commitment_from_other_research): self
    {
        $this->commitment_from_other_research = $commitment_from_other_research;

        return $this;
    }

    public function getReviewProcessStart(): ?\DateTimeInterface
    {
        return $this->review_process_start;
    }

    public function setReviewProcessStart(?\DateTimeInterface $review_process_start): self
    {
        $this->review_process_start = $review_process_start;

        return $this;
    }

    public function getReviewProcessEnd(): ?\DateTimeInterface
    {
        return $this->review_process_end;
    }

    public function setReviewProcessEnd(?\DateTimeInterface $review_process_end): self
    {
        $this->review_process_end = $review_process_end;

        return $this;
    }

    public function getReviewersDecisionWillBeCommunicatedAt(): ?\DateTimeInterface
    {
        return $this->reviewers_decision_will_be_communicated_at;
    }

    public function setReviewersDecisionWillBeCommunicatedAt( ?\DateTimeInterface $reviewers_decision_will_be_communicated_at): self
    {
        $this->reviewers_decision_will_be_communicated_at = $reviewers_decision_will_be_communicated_at;

        return $this;
    }

    public function getProjectStartsOn(): ?\DateTimeInterface
    {
        return $this->project_starts_on;
    }

    public function setProjectStartsOn(?\DateTimeInterface $project_starts_on): self
    {
        $this->project_starts_on = $project_starts_on;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(?int $views): self
    {
        $this->views = $views;

        return $this;
    }

    public function getApproved(): ?bool
    {
        return $this->approved;
    }

    public function setApproved(?bool $approved): self
    {
        $this->approved = $approved;

        return $this;
    }

    public function getApprovedBy(): ?User
    {
        return $this->approved_by;
    }

    public function setApprovedBy(?User $approved_by): self
    {
        $this->approved_by = $approved_by;

        return $this;
    }

    public function getApprovedAt(): ?\DateTimeInterface
    {
        return $this->approved_at;
    }

    public function setApprovedAt(?\DateTimeInterface $approved_at): self
    {
        $this->approved_at = $approved_at;

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

    public function getIsCallFromCenter(): ?bool
    {
        return $this->is_call_from_center;
    }

    public function setIsCallFromCenter(?bool $is_call_from_center): self
    {
        $this->is_call_from_center = $is_call_from_center;

        return $this;
    }
    public function getResearchReportPhase(): ?ResearchReportPhase
    {
        return $this->researchReportPhase;
    }

    public function setUserInfo(ResearchReportPhase $researchReportPhase): self
    {
        $this->researchReportPhase = $researchReportPhase;

        // set the owning side of the relation if necessary
        if ($researchReportPhase->getApplicationCall() !== $this) {
            $researchReportPhase->setApplicationCall($this);
        }

        return $this;
    }

 
}
