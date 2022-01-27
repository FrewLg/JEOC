<?php

namespace App\Entity;

use App\Repository\FundingInstitionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FundingInstitionRepository::class)
 */
class FundingInstition
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
    private $nameoforganization;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fund_allocated;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $currency;

    /**
     * @ORM\ManyToOne(targetEntity=Submission::class, inversedBy="fundingInstitions")
     */
    private $submission;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $memorad_of_trust;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameoforganization(): ?string
    {
        return $this->nameoforganization;
    }

    public function setNameoforganization(?string $nameoforganization): self
    {
        $this->nameoforganization = $nameoforganization;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getFundAllocated(): ?string
    {
        return $this->fund_allocated;
    }

    public function setFundAllocated(?string $fund_allocated): self
    {
        $this->fund_allocated = $fund_allocated;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;

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

    public function getMemoradOfTrust(): ?string
    {
        return $this->memorad_of_trust;
    }

    public function setMemoradOfTrust(string $memorad_of_trust): self
    {
        $this->memorad_of_trust = $memorad_of_trust;

        return $this;
    }
}
