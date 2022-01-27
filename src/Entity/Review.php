<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReviewRepository::class)
 */
class Review
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
    private $attachment;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $evaluation_attachment;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity=ReviewAssignment::class, inversedBy="reviews"  )
     * @ORM\JoinColumn(nullable=true)
     */
    private $reviewAssignment;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;


    /**
     * @ORM\Column(type="datetime" , nullable=true)
     */
    private $allowed_at;


    /**
     * @ORM\Column(type="string", length=255 , nullable=true)
     */
    private $remark;


    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reviews")
     */
    private $reviewed_by;

    /**
     * @ORM\ManyToOne(targetEntity=Submission::class, inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $submission;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $allow_to_view;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $from_director;


    public function getId(): ?int
    {
        return $this->id;
    }
 

    public function getReviewedBy() 
    {
        return $this->reviewed_by;
    }

    public function setReviewedBy(?User $reviewed_by): self
    {
        $this->reviewed_by = $reviewed_by;

        return $this;
    }
    public function getAttachment(): ?string
    {
        return $this->attachment;
    }

    public function setAttachment(?string $attachment): self
    {
        $this->attachment = $attachment;

        return $this;
    }

    public function getEvaluationAttachment(): ?string
    {
        return $this->evaluation_attachment;
    }

    public function setEvaluationAttachment(?string $evaluation_attachment): self
    {
        $this->evaluation_attachment = $evaluation_attachment;

        return $this;
    }


    

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getReviewAssignment(): ?ReviewAssignment
    {
        return $this->reviewAssignment;
    }

    public function setReviewAssignment(?ReviewAssignment $reviewAssignment): self
    {
        $this->reviewAssignment = $reviewAssignment;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAllowedAt(): ?\DateTimeInterface
    {
        return $this->allowed_at;
    }

    public function setAllowedAt(\DateTimeInterface $allowed_at): self
    {
        $this->allowed_at = $allowed_at;

        return $this;
    }

    

    public function getRemark(): ?string
    {
        return $this->remark;
    }

    public function setRemark(string $remark): self
    {
        $this->remark = $remark;

        return $this;
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

    public function getAllowToView(): ?bool
    {
        return $this->allow_to_view;
    }

    public function setAllowToView(?bool $allow_to_view): self
    {
        $this->allow_to_view = $allow_to_view;

        return $this;
    }
 
    public function getFromDirector(): ?bool
    {
        return $this->from_director;
    }

    public function setFromDirector(?bool $from_director): self
    {
        $this->from_director = $from_director;

        return $this;
    }
    

}
