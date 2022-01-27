<?php

namespace App\Entity;

use App\Repository\DirectorateOfficeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DirectorateOfficeRepository::class)
 */
class DirectorateOffice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $mission;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contact_address;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $objective;

    /**
     * @ORM\OneToMany(targetEntity=DirectorateOfficeUser::class, mappedBy="directorateOffice")
     */
    private $directorateOfficeUsers;

    public function __construct()
    {
        $this->directorateOfficeUsers = new ArrayCollection();
    }
    public function __toString()
    {
  return $this->name;
    }

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

    public function getMission(): ?string
    {
        return $this->mission;
    }

    public function setMission(?string $mission): self
    {
        $this->mission = $mission;

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

    public function getContactAddress(): ?string
    {
        return $this->contact_address;
    }

    public function setContactAddress(?string $contact_address): self
    {
        $this->contact_address = $contact_address;

        return $this;
    }

    public function getObjective(): ?string
    {
        return $this->objective;
    }

    public function setObjective(?string $objective): self
    {
        $this->objective = $objective;

        return $this;
    }

    /**
     * @return Collection|DirectorateOfficeUser[]
     */
    public function getDirectorateOfficeUsers(): Collection
    {
        return $this->directorateOfficeUsers;
    }

    public function addDirectorateOfficeUser(DirectorateOfficeUser $directorateOfficeUser): self
    {
        if (!$this->directorateOfficeUsers->contains($directorateOfficeUser)) {
            $this->directorateOfficeUsers[] = $directorateOfficeUser;
            $directorateOfficeUser->setDirectorateOffice($this);
        }

        return $this;
    }

    public function removeDirectorateOfficeUser(DirectorateOfficeUser $directorateOfficeUser): self
    {
        if ($this->directorateOfficeUsers->removeElement($directorateOfficeUser)) {
            // set the owning side to null (unless already changed)
            if ($directorateOfficeUser->getDirectorateOffice() === $this) {
                $directorateOfficeUser->setDirectorateOffice(null);
            }
        }

        return $this;
    }
}
