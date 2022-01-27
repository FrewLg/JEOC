<?php

namespace App\Entity;

use App\Repository\ResearchReportPhaseRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResearchReportPhaseRepository::class)
 */
class ResearchReportPhase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=CallForProposal::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $applicationCall;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberOfPhases;

    /**
     * @ORM\Column(type="integer")
     */
    private $maximumDuration;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $tolerableDay;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __construct() {
        $this->status= 1;
        $this->createdAt= new \DateTime();
       
    }
    public function getPhases() {
       $phases=[];
       for ($i=1; $i < $this->numberOfPhases ; $i++) { 
          $phases[$i]=date_modify($i==1?date_create($this->startDate->format('Y-m-d')):date_create($phases[$i-1]->format('Y-m-d')),"+".$this->maximumDuration." days");
        //   $phases[$i]=date_add($i==1?$this->startDate:$phases[$i-1],date_interval_create_from_date_string($this->maximumDuration." days"));
       }
       return $phases;
    }

    public function getApplicationCall(): ?CallForProposal
    {
        return $this->applicationCall;
    }

    public function setApplicationCall(CallForProposal $applicationCall): self
    {
        $this->applicationCall = $applicationCall;

        return $this;
    }

    public function getNumberOfPhases(): ?int
    {
        return $this->numberOfPhases;
    }

    public function setNumberOfPhases(int $numberOfPhases): self
    {
        $this->numberOfPhases = $numberOfPhases;

        return $this;
    }

    public function getMaximumDuration(): ?int
    {
        return $this->maximumDuration;
    }

    public function setMaximumDuration(int $maximumDuration): self
    {
        $this->maximumDuration = $maximumDuration;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

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

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getTolerableDay(): ?int
    {
        return $this->tolerableDay;
    }

    public function setTolerableDay(int $tolerableDay): self
    {
        $this->tolerableDay = $tolerableDay;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }
}
