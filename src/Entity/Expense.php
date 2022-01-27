<?php

namespace App\Entity;

use App\Repository\ExpenseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExpenseRepository::class)
 */
class Expense
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $amount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $approvedexpense;

    /**
     * @ORM\Column(type="integer", length=255, nullable=true)
     */
    private $requestedexpense;

    /**
     * @ORM\ManyToOne(targetEntity=Submission::class, inversedBy="expenses")
     */
    private $submission;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $measurement;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $unit_cost;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

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

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getApprovedexpense(): ?int
    {
        return $this->approvedexpense;
    }

    public function setApprovedexpense(?int $approvedexpense): self
    {
        $this->approvedexpense = $approvedexpense;

        return $this;
    }

    public function getRequestedexpense(): ?int
    {
        return $this->requestedexpense;
    }

    public function setRequestedexpense(?int $requestedexpense): self
    {
        $this->requestedexpense = $requestedexpense;

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

    public function getMeasurement(): ?string
    {
        return $this->measurement;
    }

    public function setMeasurement(?string $measurement): self
    {
        $this->measurement = $measurement;

        return $this;
    }

    public function getUnitCost(): ?int
    {
        return $this->unit_cost;
    }

    public function setUnitCost(?int $unit_cost): self
    {
        $this->unit_cost = $unit_cost;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

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
}
