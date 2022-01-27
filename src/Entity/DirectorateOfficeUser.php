<?php

namespace App\Entity;

use App\Repository\DirectorateOfficeUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DirectorateOfficeUserRepository::class)
 */
class DirectorateOfficeUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=DirectorateOffice::class, inversedBy="directorateOfficeUsers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $directorateOffice;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="directorateOfficeUsers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $directorate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $assignedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDirectorateOffice(): ?DirectorateOffice
    {
        return $this->directorateOffice;
    }

    public function setDirectorateOffice(?DirectorateOffice $directorateOffice): self
    {
        $this->directorateOffice = $directorateOffice;

        return $this;
    }

    public function getDirectorate(): ?User
    {
        return $this->directorate;
    }

    public function setDirectorate(?User $directorate): self
    {
        $this->directorate = $directorate;

        return $this;
    }

    public function getAssignedAt(): ?\DateTimeInterface
    {
        return $this->assignedAt;
    }

    public function setAssignedAt(\DateTimeInterface $assignedAt): self
    {
        $this->assignedAt = $assignedAt;

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
}
