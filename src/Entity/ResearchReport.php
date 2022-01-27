<?php

namespace App\Entity;

use App\Repository\ResearchReportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResearchReportRepository::class)
 */
class ResearchReport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Submission::class, inversedBy="researchReports")
     * @ORM\JoinColumn(nullable=false)
     */
    private $submission;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $fileType;

    /**
     * @ORM\Column(type="datetime")
     */
    private $submittedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $submissionStatus;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $submittedBy;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $remark;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=ResearchReportReview::class, mappedBy="researchReport", orphanRemoval=true)
     */
    private $researchReportReviews;

    public function __construct()
    {
        $this->submissionStatus=1;
        $this->submittedAt=new \DateTime('now');
        $this->researchReportReviews = new ArrayCollection();
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getFileType(): ?string
    {
        return $this->fileType;
    }

    public function setFileType(string $fileType): self
    {
        $this->fileType = $fileType;

        return $this;
    }

    public function getSubmittedAt(): ?\DateTimeInterface
    {
        return $this->submittedAt;
    }

    public function setSubmittedAt(\DateTimeInterface $submittedAt): self
    {
        $this->submittedAt = $submittedAt;

        return $this;
    }

    public function getSubmissionStatus(): ?int
    {
        return $this->submissionStatus;
    }

    public function setSubmissionStatus(int $submissionStatus): self
    {
        $this->submissionStatus = $submissionStatus;

        return $this;
    }

    public function getSubmittedBy(): ?User
    {
        return $this->submittedBy;
    }

    public function setSubmittedBy(?User $submittedBy): self
    {
        $this->submittedBy = $submittedBy;

        return $this;
    }

    public function getRemark(): ?string
    {
        return $this->remark;
    }

    public function setRemark(?string $remark): self
    {
        $this->remark = $remark;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|ResearchReportReview[]
     */
    public function getResearchReportReviews(): Collection
    {
        return $this->researchReportReviews;
    }

    public function addResearchReportReview(ResearchReportReview $researchReportReview): self
    {
        if (!$this->researchReportReviews->contains($researchReportReview)) {
            $this->researchReportReviews[] = $researchReportReview;
            $researchReportReview->setResearchReport($this);
        }

        return $this;
    }

    public function removeResearchReportReview(ResearchReportReview $researchReportReview): self
    {
        if ($this->researchReportReviews->removeElement($researchReportReview)) {
            // set the owning side to null (unless already changed)
            if ($researchReportReview->getResearchReport() === $this) {
                $researchReportReview->setResearchReport(null);
            }
        }

        return $this;
    }
}
