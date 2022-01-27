<?php

namespace App\Entity;

use App\Repository\EditorialDecisionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EditorialDecisionRepository::class)
 */
class EditorialDecision
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
    private $decision;

    /**
     * @ORM\ManyToOne(targetEntity=Submission::class, inversedBy="editorialDecisions")
     */
    private $submission;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $revised_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="editorialDecisions")
     */
    private $edited_by;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $feedback;

    public function getId(): ?int
    {
        return $this->id;
    }

 

    public function getDecision(): ?string
    {
        return $this->decision;
    }

    public function setDecision(?string $decision): self
    {
        $this->decision = $decision;

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

    public function getRevisedAt(): ?\DateTimeInterface
    {
        return $this->revised_at;
    }

    public function setRevisedAt(?\DateTimeInterface $revised_at): self
    {
        $this->revised_at = $revised_at;

        return $this;
    }

    public function getEditedBy(): ?User
    {
        return $this->edited_by;
    }

    public function setEditedBy(?User $edited_by): self
    {
        $this->edited_by = $edited_by;

        return $this;
    }

    public function getFeedback(): ?string
    {
        return $this->feedback;
    }

    public function setFeedback(?string $feedback): self
    {
        $this->feedback = $feedback;

        return $this;
    }
}
