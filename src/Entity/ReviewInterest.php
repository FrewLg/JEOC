<?php

namespace App\Entity;

use App\Repository\ReviewInterestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReviewInterestRepository::class)
 */
class ReviewInterest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reviewInterests")
     */
    private $researcher;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $interest;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResearcher(): ?User
    {
        return $this->researcher;
    }

    public function setResearcher(?User $researcher): self
    {
        $this->researcher = $researcher;

        return $this;
    }

    public function getInterest(): ?string
    {
        return $this->interest;
    }

    public function setInterest(?string $interest): self
    {
        $this->interest = $interest;

        return $this;
    }
}
