<?php

namespace App\Entity;

use App\Repository\ResearchTimeTableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResearchTimeTableRepository::class)
 */
class  ResearchTimeTable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Submission::class, inversedBy="ResearchTimeTables")
     * @ORM\JoinColumn(nullable=false)
     */
    private $submission;


   /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $task;

  /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_start;

/**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_end;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $remark;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_accomplished;


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

    public function getIsAccomplished(): ?bool
    {
        return $this->is_accomplished;
    }

    public function setIsAccomplished(?bool $is_accomplished): self
    {
        $this->is_accomplished = $is_accomplished;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(?\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }



    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end ;
    }

    public function setDateEnd(?\DateTimeInterface $date_end ): self
    {
        $this->date_end  = $date_end ;

        return $this;
    }

    public function getTask(): ?string
    {
        return $this->task;
    }

    public function setTask(string $task): self
    {
        $this->task = $task;

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

    

   
}
