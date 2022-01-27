<?php

namespace App\Entity;

use App\Repository\UserInfoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;  

/**
 * @ORM\Entity(repositoryClass=UserInfoRepository::class)
 */
class UserInfo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

  

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bio;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
         * @Assert\Regex( pattern="/\d/", match=false,  message="the middle Name '{{ value }}' is not valid. middle name doesn't contain numbers ")
  
     */
    private $midle_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
      * @Assert\Regex( pattern="/\d/", match=false,  message="the lastName '{{ value }}' is not valid. last name doesn't contain numbers ")
  
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
    * @Assert\Regex( pattern="/\d/", match=false,  message="the first Name '{{ value }}' is not valid. first name doesn't contain numbers ")
  
     */
    private $first_name;

      /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $affiliation;

   
 

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
      * @Assert\Regex( pattern="/^(\+|)[0-9]{12}$/",   message="the phone number '{{ value }}' is not valid.  ")
       */
   
//    /* 
//      * @ORM\Column(type="string", length=255, nullable=true)
//      *  @Assert\Length(min = 8, max = 20, minMessage = "min_lenght", maxMessage = "max_lenght")
//     *@Assert\Regex(pattern="/^[0-9]*$/", message="number_only") 
//     */
    private $phoneNumber;
    /**
    * @ORM\Column(type="string", length=250, nullable=true)
    
     */
    private $image;
 
    /**
     * @ORM\Column(type="datetime", length=255, nullable=true)
     */
    private $birth_date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;
    
     
      /**
     * @ORM\ManyToOne(targetEntity=College::class)
     */
    private $college;

    /**
     * @ORM\ManyToOne(targetEntity=Department::class)
     */
    private $department;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="userInfo", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    
    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $hasCompleteProfile;

    

    /**
     * @ORM\ManyToOne(targetEntity=EducationalLevel::class, inversedBy="userInfos")
     */
    private $education_level;

    /**
     * @ORM\ManyToOne(targetEntity=AcademicRank::class, inversedBy="userInfos")
     */
    private $academic_rank;

   

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $alternative_email;

    /**
     * @ORM\ManyToOne(targetEntity=Suffixe::class, inversedBy="userInfos")
     * @ORM\JoinColumn(nullable=true)
     */
    private $suffix;



    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString()
    {
        
  
    
        return $this->getFirstName()." ".$this->getMidleName()." ".$this->getLastName();
     
    }

    public function __construct()
    {
  
         $this->researches = new ArrayCollection();
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

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(?string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(?string $first_name): self
    {
        $this->first_name = $first_name;

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
      /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getImage(): string
    {
        return (string) $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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

    

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getBirthDate(): ?\DateTime 
    {
        return $this->birth_date;
    }

    public function setBirthDate(?\DateTime  $birth_date): self
    {
        $this->birth_date = $birth_date;

        return $this;
    }


   

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

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

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getHasCompleteProfile(): ?bool
    {
        return $this->hasCompleteProfile;
    }

    public function setHasCompleteProfile(bool $hasCompleteProfile): self
    {
        $this->hasCompleteProfile = $hasCompleteProfile;

        return $this;
    }
 

    public function getEducationLevel(): ?EducationalLevel
    {
        return $this->education_level;
    }

    public function setEducationLevel(?EducationalLevel $education_level): self
    {
        $this->education_level = $education_level;

        return $this;
    }

    public function getAcademicRank(): ?AcademicRank
    {
        return $this->academic_rank;
    }

    public function setAcademicRank(?AcademicRank $academic_rank): self
    {
        $this->academic_rank = $academic_rank;

        return $this;
    }
 

    public function getAlternativeEmail(): ?string
    {
        return $this->alternative_email;
    }

    public function setAlternativeEmail(?string $alternative_email): self
    {
        $this->alternative_email = $alternative_email;

        return $this;
    }

    public function getSuffix(): ?Suffixe
    {
        return $this->suffix;
    }

    public function setSuffix(?Suffixe $suffix): self
    {
        $this->suffix = $suffix;

        return $this;
    }
}
