<?php

namespace App\Entity;

use App\Repository\PublishedSubmissionAttachmentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PublishedSubmissionAttachmentRepository::class)
 */
class PublishedSubmissionAttachment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
 
    /**
     * @ORM\ManyToOne(targetEntity=AttachementType::class, inversedBy="publishedSubmissionAttachments")
     */
    private $attachment_type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attachment_file;

    /**
     * @ORM\Column(type="string", length=1500, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $uploaded_at;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_approved;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dataset_label;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sample_size;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $study_region;

    /**
     * @ORM\ManyToOne(targetEntity=DataSource::class, inversedBy="publishedSubmissionAttachments")
     */
    private $data_source;

    /**
     * @ORM\ManyToOne(targetEntity=PublishedSubmission::class, inversedBy="publishedSubmissionAttachments")
     */
    private $published_submission;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAttachmentType(): ?AttachementType
    {
        return $this->attachment_type;
    }

    public function setAttachmentType(?AttachementType $attachment_type): self
    {
        $this->attachment_type = $attachment_type;

        return $this;
    }

    public function getAttachmentFile(): ?string
    {
        return $this->attachment_file;
    }

    public function setAttachmentFile(?string $attachment_file): self
    {
        $this->attachment_file = $attachment_file;

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

    public function getUploadedAt(): ?\DateTimeInterface
    {
        return $this->uploaded_at;
    }

    public function setUploadedAt(?\DateTimeInterface $uploaded_at): self
    {
        $this->uploaded_at = $uploaded_at;

        return $this;
    }

    public function getIsApproved(): ?bool
    {
        return $this->is_approved;
    }

    public function setIsApproved(?bool $is_approved): self
    {
        $this->is_approved = $is_approved;

        return $this;
    }

    public function getDatasetLabel(): ?string
    {
        return $this->dataset_label;
    }

    public function setDatasetLabel(?string $dataset_label): self
    {
        $this->dataset_label = $dataset_label;

        return $this;
    }

    public function getSampleSize(): ?int
    {
        return $this->sample_size;
    }

    public function setSampleSize(?int $sample_size): self
    {
        $this->sample_size = $sample_size;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getCodebook(): ?string
    {
        return $this->codebook;
    }

    public function setCodebook(?string $codebook): self
    {
        $this->codebook = $codebook;

        return $this;
    }

    public function getStudyRegion(): ?string
    {
        return $this->study_region;
    }

    public function setStudyRegion(?string $study_region): self
    {
        $this->study_region = $study_region;

        return $this;
    }

    public function getDataSource(): ?DataSource
    {
        return $this->data_source;
    }

    public function setDataSource(?DataSource $data_source): self
    {
        $this->data_source = $data_source;

        return $this;
    }

    public function getPublishedSubmission(): ?PublishedSubmission
    {
        return $this->published_submission;
    }

    public function setPublishedSubmission(?PublishedSubmission $published_submission): self
    {
        $this->published_submission = $published_submission;

        return $this;
    }
}
