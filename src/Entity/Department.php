<?php

namespace App\Entity;

use App\Repository\DepartmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DepartmentRepository::class)
 */
class Department
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=College::class, inversedBy="departments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $college;

      /**
     * @ORM\OneToMany(targetEntity=UserInfo::class, mappedBy="department")
     */
    private $userInfos;


    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString()
    {
        
   
        return $this->name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

   

    public function __construct()
    {
   
        $this->users = new ArrayCollection(); 
    }

    /**
     * @return Collection|userInfo[]
     */
    public function getUserInfos(): Collection
    {
        return $this->userInfos;
    }

    public function addUserInfo(userInfo $userInfo): self
    {
        if (!$this->userInfos->contains($userInfo)) {
            $this->userInfos[] = $userInfo;
            $userInfo->setDepartment($this);
        }

        return $this;
    }

    public function removeUserInfo(userInfo $userInfo): self
    {
        if ($this->userInfos->removeElement($userInfo)) {
            // set the owning side to null (unless already changed)
            if ($userInfo->getDepartment() === $this) {
                $userInfo->setDepartment(null);
            }
        }

        return $this;
    }

 

}
