<?php

namespace App\Entity;

use App\Repository\ReviewAssignmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;  

/**
 * @ORM\Entity(repositoryClass=ReviewAssignmentRepository::class)
 */
class ReviewAssignment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Submission::class, inversedBy="submission_reviewAssignments")
     */
    private $submission;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rewiewer_reviewAssignments")
     */
    private $reviewer; 
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $duedate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $invitation_sent_at;
    // ^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@\ju.edu.et

    /**
     * @ORM\Column(type="string", length=255, nullable=true)     
     */
    private $external_reviewer_email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $external_reviewer_name;

     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $middle_name;


     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $last_name;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Declined;




    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reassigned;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $file_tobe_reviewed;


    /**
     * @ORM\Column(type="date")
     */
    private $invitationDueDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $acceptedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $rejectedAt;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="reviewAssignment", orphanRemoval=true)
     */
    private $reviews;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $closed;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $inactive_assignment;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubmission(): ?Submission
    {
        return $this->submission;
    }

    public function setSubmission(?Submission $submission): self
    {
        $this->submission = $submission;

        return $this;
    }

    public function getReviewer() 
    {
        return $this->reviewer;
    }

    public function setReviewer(?User $reviewer): self
    {
        $this->reviewer = $reviewer;

        return $this;
    }

    public function getDuedate(): ?\DateTimeInterface
    {
        return $this->duedate;
    }

    public function setDuedate(?\DateTimeInterface $duedate): self
    {
        $this->duedate = $duedate;

        return $this;
    }

    public function getInvitationSentAt(): ?\DateTimeInterface
    {
        return $this->invitation_sent_at;
    }

    public function setInvitationSentAt(?\DateTimeInterface $invitation_sent_at): self
    {
        $this->invitation_sent_at = $invitation_sent_at;

        return $this;
    }
    
    public function getDeclined(): ?string
    {
        return $this->Declined;
    }
    public function setDeclined(?string $Declined): self
    {
        $this->Declined = $Declined;

        return $this;
    }


    public function getReassigned(): ?string
    {
        return $this->reassigned;
    }
    public function setReassigned(?string $reassigned): self
    {
        $this->reassigned = $reassigned;

        return $this;
    }


    
    public function getFileTobeReviewedeclined(): ?string
    {
        return $this->file_tobe_reviewed;
    }
    public function setFileTobeReviewed(?string $file_tobe_reviewed): self
    {
        $this->file_tobe_reviewed = $file_tobe_reviewed;

        return $this;
    }

    

    public function getExternalrevieweremail(): ?string
    {
        return $this->external_reviewer_email;
    }
    public function setExternalrevieweremail(?string $external_reviewer_email): self
    {
        $this->external_reviewer_email = $external_reviewer_email;

        return $this;
    }

 
    
    public function getExternalreviewerName(): ?string
    {
        return $this->external_reviewer_name;
    }
    
    public function setExternalreviewerName(?string $external_reviewer_name): self
    {
        $this->external_reviewer_name = $external_reviewer_name;

        return $this;
    }

    
    
    public function getMiddleName(): ?string
    {
        return $this->middle_name;
    }
    
    public function setMiddleName(?string $middle_name): self
    {
        $this->middle_name = $middle_name;

        return $this;
    }
    


    
    public function getLastName(): ?string
    {
        return $this->last_name;
    }
    
    public function setLastName(?string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }
    

    public function getInvitationDueDate(): ?\DateTimeInterface
    {
        return $this->invitationDueDate;
    }

    public function setInvitationDueDate(\DateTimeInterface $invitationDueDate): self
    {
        $this->invitationDueDate = $invitationDueDate;

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

    public function getAcceptedAt(): ?\DateTimeInterface
    {
        return $this->acceptedAt;
    }

    public function setAcceptedAt(?\DateTimeInterface $acceptedAt): self
    {
        $this->acceptedAt = $acceptedAt;

        return $this;
    }

    public function getRejectedAt(): ?\DateTimeInterface
    {
        return $this->rejectedAt;
    }

    public function setRejectedAt(?\DateTimeInterface $rejectedAt): self
    {
        $this->rejectedAt = $rejectedAt;

        return $this;
    }
    public function getIsAccepted()
    {
        return $this->acceptedAt != null;
    }
    public function getIsRejected()
    {
        return $this->rejectedAt != null;
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
            $review->setReviewAssignment($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getReviewAssignment() === $this) {
                $review->setReviewAssignment(null);
            }
        }

        return $this;
    }

    public function getClosed(): ?bool
    {
        return $this->closed;
    }

    public function setClosed(?bool $closed): self
    {
        $this->closed = $closed;

        return $this;
    }

    public function getInactiveAssignment(): ?bool
    {
        return $this->inactive_assignment;
    }

    public function setInactiveAssignment(?bool $inactive_assignment): self
    {
        $this->inactive_assignment = $inactive_assignment;

        return $this;
    }
    
}
