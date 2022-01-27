<?php

namespace App\Entity;

use App\Repository\CollaboratingInstitutionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CollaboratingInstitutionRepository::class)
 */
class CollaboratingInstitution
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
     * @ORM\Column(type="string", length=2000, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Submission::class, inversedBy="collaboratingInstitutions")
     */
    private $submission;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $amountgranted;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attachment_of_grant_award;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getAmountgranted(): ?int
    {
        return $this->amountgranted;
    }

    public function setAmountgranted(?int $amountgranted): self
    {
        $this->amountgranted = $amountgranted;

        return $this;
    }

    public function getAttachmentOfGrantAward(): ?string
    {
        return $this->attachment_of_grant_award;
    }

    public function setAttachmentOfGrantAward(?string $attachment_of_grant_award): self
    {
        $this->attachment_of_grant_award = $attachment_of_grant_award;

        return $this;
    }
}
