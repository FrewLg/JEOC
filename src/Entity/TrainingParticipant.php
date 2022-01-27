<?php

namespace App\Entity;

use App\Repository\TrainingParticipantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrainingParticipantRepository::class)
 */
class TrainingParticipant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="trainingParticipants")
     */
    private $participant;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $applied_at;

    /**
     * @ORM\ManyToOne(targetEntity=CallForTraining::class, inversedBy="trainingParticipants")
     */
    private $training;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $participated;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $certificate_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParticipant(): ?User
    {
        return $this->participant;
    }

    public function setParticipant(?User $participant): self
    {
        $this->participant = $participant;

        return $this;
    }

    public function getAppliedAt(): ?\DateTime 
    {
        return $this->applied_at;
    }

    public function setAppliedAt(?\DateTime  $applied_at): self
    {
        $this->applied_at = $applied_at;

        return $this;
    }

    public function getTraining(): ?CallForTraining
    {
        return $this->training;
    }

    public function setTraining(?CallForTraining $training): self
    {
        $this->training = $training;

        return $this;
    }

    public function getParticipated(): ?bool
    {
        return $this->participated;
    }

    public function setParticipated(?bool $participated): self
    {
        $this->participated = $participated;

        return $this;
    }

    public function getCertificateId(): ?string
    {
        return $this->certificate_id;
    }

    public function setCertificateId(?string $certificate_id): self
    {
        $this->certificate_id = $certificate_id;

        return $this;
    }
}
