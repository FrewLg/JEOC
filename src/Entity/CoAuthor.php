<?php

namespace App\Entity;

use App\Repository\CoAuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
#use Gedmo\Mapping\Annotation as Gedmo;
/**
 * @ORM\Entity(repositoryClass=CoAuthorRepository::class)
 */
class CoAuthor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Submission::class, inversedBy="coAuthors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $submission;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $affiliation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

     

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cv;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="string" , length=1000, nullable=true)
     */
    private $bio;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;

 
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $orcid;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="coAuthors")
     */
    private $country;
 /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $confirmed;
    /**
     * @ORM\ManyToOne(targetEntity=Title::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=Department::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $department;

    /**
     * @ORM\ManyToOne(targetEntity=MemberRole::class, inversedBy="coAuthors")
     * @ORM\JoinColumn(nullable=true)
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $midle_name;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="coAuthors")
     */
    private $researcher;

   
  
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

public function addSubmission(Submission $submission): void
{
    if (!$this->tasks->contains($submission)) {
        $this->Submissions->add($submission);
    }
}

    public function getName(): ?string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->title ." " . $this->name;
    }


    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
 
    public function getConfirmed(): ?bool
    {
        return $this->confirmed;
    }

    public function setConfirmed(?bool $confirmed): self
    {
        $this->confirmed = $confirmed;

        return $this;
    }


    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(?string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getAffiliation(): ?string
    {
        return $this->affiliation;
    }

    public function setAffiliation(?string $affiliation): self
    {
        $this->affiliation = $affiliation;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }
 

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(?string $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

 

   

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getOrcid(): ?string
    {
        return $this->orcid;
    }

    public function setOrcid(?string $orcid): self
    {
        $this->orcid = $orcid;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getTitle(): ?Title
    {
        return $this->title;
    }

    public function setTitle(?Title $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getRole(): ?MemberRole
    {
        return $this->role;
    }

    public function setRole(?MemberRole $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getMidleName(): ?string
    {
        return $this->midle_name;
    }

    public function setMidleName(?string $midle_name): self
    {
        $this->midle_name = $midle_name;

        return $this;
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

    

 
}
