<?php

namespace App\Entity;

use App\Repository\PublishedResearchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Form;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

 

 /**
 * PublishedResearch 
 *
 * @ORM\Table(name="published_research")
 * 
 * @ORM\Entity(repositoryClass=PublishedResearchRepository::class)
 * @Vich\Uploadable
 */

class  PublishedResearch
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
 
//    /**
//      * @ORM\Column(type="string", length=255, nullable=true)
//      */
//     private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $allotted_budget;
 
//   /**
//      * @ORM\Column(type="datetime", nullable=true)
//      */
//     private $year;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $final_report;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $remark;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $successfully_completed;

    /**
     * @ORM\OneToOne(targetEntity=Submission::class, inversedBy="publishedResearch", cascade={"persist", "remove"})
     */
    private $submission; 

     

    /**
     * @ORM\ManyToOne(targetEntity=UserInfo::class, inversedBy="researches"  , cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     * 
     */
    private $userInfo;


     
      /**
     * 
     * @Vich\UploadableField(mapping="imageFile", fileNameProperty="imageFile")
     * 
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="integer" , length=255, nullable=true)
     *
     * @var int|null
     */
    private $imageSize;


    /**
     * @ORM\ManyToOne(targetEntity=PublishedTopic::class, inversedBy="title")
     * @ORM\JoinColumn(nullable=false)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=AcademicYear::class, inversedBy="publishedResearch")
     */
    private $year;

   
        /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
   
    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
 

    

    public function getFinalReport(): ?string
    {
        return $this->final_report;
    }

    public function setFinalReport(?string $final_report): self
    {
        $this->final_report = $final_report;

        return $this;
    }
    public function getSuccessfullyCompleted(): ?bool
    {
        return $this->successfully_completed;
    }

    public function setSuccessfullyCompleted(?bool $successfully_completed): self
    {
        $this->successfully_completed = $successfully_completed;

        return $this;
    }

   



    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end ;
    }

    public function setDateEnd(?\DateTimeInterface $date_end ): self
    {
        $this->date_end  = $date_end ;

        return $this;
    }
 
    public function getAllottedBudget(): ?string
    {
        return $this->allotted_budget;
    }

    public function setAllottedBudget(string $allotted_budget): self
    {
        $this->allotted_budget = $allotted_budget;

        return $this;
    }

    public function getRemark(): ?string
    {
        return $this->remark;
    }

    public function setRemark(?string $remark): self
    {
        $this->remark = $remark;

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
 
   
//     public function saveIrbClearance(Form $form)
// {
//     $userInfo = $this->getUser->getUserInfo();
//     $Emailpicture=$userInfo->getFirstName();
//         $prifilepicture = $form->get('image')->getData();
//         $fileName3 =  md5($Emailpicture) . '.' . $prifilepicture->guessExtension();
//         $prifilepicture->move($this->getParameter('profile_pictures'), $fileName3);
        
//         $userInfo->setIrbClearance($fileName3);
//         return $this;
    
// }

    public function getUserInfo(): ?UserInfo
    {
        return $this->userInfo;
    }

    public function setUserInfo(?UserInfo $userInfo): self
    {
        $this->userInfo = $userInfo;

        return $this;
    }

    // public function getTitle(): ?PublishedTopic
    // {
    //     return $this->title;
    // }

    // public function setTitle(PublishedTopic $title): self
    // {
    //     $this->title = $title;

    //     return $this;
    // } 

    public function getTitle(): ?PublishedTopic
    {
        return $this->title;
    }

    public function setTitle(?PublishedTopic $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getYear(): ?AcademicYear
    {
        return $this->year;
    }

    public function setYear(?AcademicYear $year): self
    {
        $this->year = $year;

        return $this;
    }

    
}
