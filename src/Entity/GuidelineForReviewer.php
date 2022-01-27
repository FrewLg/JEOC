<?php

namespace App\Entity;

use App\Repository\GuidelineForReviewerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GuidelineForReviewerRepository::class)
 */
class GuidelineForReviewer
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attachment;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $evaluationfrom;
 

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commentfrom;
    /**
     * @ORM\ManyToOne(targetEntity=WorkUnit::class, inversedBy="guidelineForReviewers")
     */
    private $workunit;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $the_guidelline;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\OneToOne(targetEntity=College::class, inversedBy="guidelineForReviewer", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $college;

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


    public function getAttachment(): ?string
    {
        return $this->attachment;
    }

    public function setAttachment(?string $attachment): self
    {
        $this->attachment = $attachment;

        return $this;
    }


    public function getEvaluationfrom(): ?string
    {
        return $this->evaluationfrom;
    }

    public function setEvaluationfrom(?string $evaluationfrom): self
    {
        $this->evaluationfrom = $evaluationfrom;

        return $this;
    }

    public function getCommentfrom(): ?string
    {
        return $this->commentfrom;
    }

    public function setCommentfrom(?string $commentfrom): self
    {
        $this->commentfrom = $commentfrom;

        return $this;
    }
    
    public function getWorkunit(): ?WorkUnit
    {
        return $this->workunit;
    }

    public function setWorkunit(?WorkUnit $workunit): self
    {
        $this->workunit = $workunit;

        return $this;
    }

    public function getTheGuidelline(): ?string
    {
        return $this->the_guidelline;
    }

    public function setTheGuidelline(?string $the_guidelline): self
    {
        $this->the_guidelline = $the_guidelline;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCollege(): ?College
    {
        return $this->college;
    }

    public function setCollege(?College $college): self
    {
        $this->college = $college;

        return $this;
    }
}
