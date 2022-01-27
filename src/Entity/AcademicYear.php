<?php

namespace App\Entity;

use App\Repository\AcademicYearRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AcademicYearRepository::class)
 */
class AcademicYear
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
    private $year_name;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYearName(): ?string
    {
        return $this->year_name;
    }

    public function setYearName(?string $year_name): self
    {
        $this->year_name = $year_name;

        return $this;
    }
    public function __toString()
    {
     return $this->year_name;   
    }
     
}
