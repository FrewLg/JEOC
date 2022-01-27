<?php

namespace App\Entity;

use App\Repository\PublishedSubmissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PublishedSubmissionRepository::class)
 */
class PublishedSubmission
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Submission::class, inversedBy="publishedSubmissions")
     */
    private $submission;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $published_date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $final_report;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $published;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $feedback_from_director;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_approved_publication;

    /**
     * @ORM\ManyToOne(targetEntity=AttachementType::class, inversedBy="publishedSubmissions")
     */
    private $attachement_type;

    /**
     * @ORM\OneToMany(targetEntity=PublishedSubmissionAttachment::class, mappedBy="published_submission")
     */
    private $publishedSubmissionAttachments;

    public function __construct()
    {
        $this->publishedSubmissionAttachments = new ArrayCollection();
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

    public function getPublishedDate(): ?\DateTimeInterface
    {
        return $this->published_date;
    }

    public function setPublishedDate(?\DateTimeInterface $published_date): self
    {
        $this->published_date = $published_date;

        return $this;
    }

    public function getFinalReport(): ?string
    {
        return $this->final_report;
    }

    public function setFinalReport(?string $final_report): self
    {
        $this->final_report = $final_report;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(?bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getFeedbackFromDirector(): ?string
    {
        return $this->feedback_from_director;
    }

    public function setFeedbackFromDirector(?string $feedback_from_director): self
    {
        $this->feedback_from_director = $feedback_from_director;

        return $this;
    }

    public function getIsApprovedPublication(): ?bool
    {
        return $this->is_approved_publication;
    }

    public function setIsApprovedPublication(?bool $is_approved_publication): self
    {
        $this->is_approved_publication = $is_approved_publication;

        return $this;
    }

    public function getAttachementType(): ?AttachementType
    {
        return $this->attachement_type;
    }

    public function setAttachementType(?AttachementType $attachement_type): self
    {
        $this->attachement_type = $attachement_type;

        return $this;
    }

    /**
     * @return Collection|PublishedSubmissionAttachment[]
     */
    public function getPublishedSubmissionAttachments(): Collection
    {
        return $this->publishedSubmissionAttachments;
    }

    public function addPublishedSubmissionAttachment(PublishedSubmissionAttachment $publishedSubmissionAttachment): self
    {
        if (!$this->publishedSubmissionAttachments->contains($publishedSubmissionAttachment)) {
            $this->publishedSubmissionAttachments[] = $publishedSubmissionAttachment;
            $publishedSubmissionAttachment->setPublishedSubmission($this);
        }

        return $this;
    }

    public function removePublishedSubmissionAttachment(PublishedSubmissionAttachment $publishedSubmissionAttachment): self
    {
        if ($this->publishedSubmissionAttachments->removeElement($publishedSubmissionAttachment)) {
            // set the owning side to null (unless already changed)
            if ($publishedSubmissionAttachment->getPublishedSubmission() === $this) {
                $publishedSubmissionAttachment->setPublishedSubmission(null);
            }
        }

        return $this;
    }
}
