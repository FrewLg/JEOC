<?php

namespace App\Entity;

use App\Repository\MemberRoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MemberRoleRepository::class)
 */
class MemberRole
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
    private $rolename;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=CoAuthor::class, mappedBy="role", orphanRemoval=true)
     */
    private $coAuthors;

    public function __construct()
    {
        $this->coAuthors = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRolename(): ?string
    {
        return $this->rolename;
    }

    public function setRolename(?string $rolename): self
    {
        $this->rolename = $rolename;

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

    public function __toString()
    {
     return $this->rolename;   
    }

    /**
     * @return Collection|CoAuthor[]
     */
    public function getCoAuthors(): Collection
    {
        return $this->coAuthors;
    }

    public function addCoAuthor(CoAuthor $coAuthor): self
    {
        if (!$this->coAuthors->contains($coAuthor)) {
            $this->coAuthors[] = $coAuthor;
            $coAuthor->setRole($this);
        }

        return $this;
    }

    public function removeCoAuthor(CoAuthor $coAuthor): self
    {
        if ($this->coAuthors->removeElement($coAuthor)) {
            // set the owning side to null (unless already changed)
            if ($coAuthor->getRole() === $this) {
                $coAuthor->setRole(null);
            }
        }

        return $this;
    }

   
}
