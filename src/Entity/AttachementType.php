<?php

namespace App\Entity;

use App\Repository\AttachementTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AttachementTypeRepository::class)
 */
class AttachementType
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
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Submission::class, inversedBy="attachementTypes")
     */
    private $submission;

    /**
     * @ORM\OneToMany(targetEntity=PublishedSubmissionAttachment::class, mappedBy="attachment_type")
     */
    private $publishedSubmissionAttachments;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=PublishedSubmission::class, mappedBy="attachement_type")
     */
    private $publishedSubmissions;

    public function __construct()
    {
        $this->publishedSubmissionAttachments = new ArrayCollection();
        $this->publishedSubmissions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
   function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getName();
    }  
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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
            $publishedSubmissionAttachment->setAttachmentType($this);
        }

        return $this;
    }

    public function removePublishedSubmissionAttachment(PublishedSubmissionAttachment $publishedSubmissionAttachment): self
    {
        if ($this->publishedSubmissionAttachments->removeElement($publishedSubmissionAttachment)) {
            // set the owning side to null (unless already changed)
            if ($publishedSubmissionAttachment->getAttachmentType() === $this) {
                $publishedSubmissionAttachment->setAttachmentType(null);
            }
        }

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
            $publishedSubmission->setAttachementType($this);
        }

        return $this;
    }

    public function removePublishedSubmission(PublishedSubmission $publishedSubmission): self
    {
        if ($this->publishedSubmissions->removeElement($publishedSubmission)) {
            // set the owning side to null (unless already changed)
            if ($publishedSubmission->getAttachementType() === $this) {
                $publishedSubmission->setAttachementType(null);
            }
        }

        return $this;
    }
}
