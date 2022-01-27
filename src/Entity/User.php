<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;  
// use Symfony\Component\Security\Core\User\UserInterface;
/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=180, nullable=true, unique=true)
     */
    private $email;

 
    /**
     * @ORM\Column(type="string", length=180, nullable=true, unique=true)
     */
    private $username;

 /**
     * @ORM\Column(type="json", nullable=true)
     */   
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\OneToMany(targetEntity=Proposal::class, mappedBy="author")
     */
    private $proposals;

    /**
     * @ORM\OneToMany(targetEntity=Submission::class, mappedBy="author")
     */
    private $submissions; 
  
 /**
     * @ORM\ManyToOne(targetEntity=Review::class, inversedBy="reviewed_by")
     */
    private $reviews;
    /**
     * @ORM\OneToMany(targetEntity=InstitutionalReviewersBoard::class, mappedBy="reviewer")
     */
    private $institutionalReviewersBoards;

    /**
     * @ORM\OneToMany(targetEntity=ReviewAssignment::class, mappedBy="reviewer")
     */
    private $reviewAssignments;

    /**
     * @ORM\OneToMany(targetEntity=InstitutionalReviewersBoard::class, mappedBy="name")
     */
    private $i_r_b_member;

    
   /**
     * @ORM\ManyToMany(targetEntity=UserGroup::class, inversedBy="users")
     */
    private $userGroup;

    
     
         /**
     * @ORM\ManyToMany(targetEntity=Permission::class, inversedBy="users_permissions")
     *
     * @var \Doctrine\Common\Collections\Collection
     */
    private $permissions;

  
    /**
     * @ORM\OneToMany(targetEntity=EditorialDecision::class, mappedBy="edited_by")
     */
    private $editorialDecisions;

    /**
     * @ORM\OneToMany(targetEntity=CallForProposal::class, mappedBy="approved_by")
     */
    private $callForProposals;

    /**
     * @ORM\OneToMany(targetEntity=Subscription::class, mappedBy="user")
     */
    private $subscriptions;

    
    /**
     * @ORM\OneToMany(targetEntity=Announcement::class, mappedBy="posted_by")
     */
    private $announcements;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isSuperAdmin;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $registeredAt;

    /**
     * @ORM\OneToOne(targetEntity=UserInfo::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $userInfo;

    /**
     * @ORM\OneToMany(targetEntity=CoAuthor::class, mappedBy="researcher")
     */
    private $coAuthors;

    /**
     * @ORM\OneToMany(targetEntity=UserFeedback::class, mappedBy="user", orphanRemoval=true)
     */
    private $userFeedback;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_reviewer;

    /**
     * @ORM\OneToMany(targetEntity=TrainingParticipant::class, mappedBy="participant")
     */
    private $trainingParticipants;

 
      /**
     * @ORM\OneToMany(targetEntity=DirectorateOfficeUser::class, mappedBy="directorate" , orphanRemoval=true,cascade={"persist"})
     */
    private $directorateOfficeUsers;


     
    public function __construct()
    {
        $this->isSuperAdmin =0;
        $this->isActive =1;
        $this->registeredAt=new \DateTime('now');
        $this->userGroup = new ArrayCollection();
        $this->proposals = new ArrayCollection(); 
        $this->institutionalReviewersBoards = new ArrayCollection();
        $this->reviewAssignments = new ArrayCollection();
        $this->i_r_b_member = new ArrayCollection();
        $this->directorateOfficeUsers = new ArrayCollection();
        $this->permissions = new ArrayCollection();
        $this->editorialDecisions = new ArrayCollection();
        $this->submissions = new ArrayCollection();
        
        $this->callForProposals = new ArrayCollection();
        $this->subscriptions = new ArrayCollection();
        $this->announcements = new ArrayCollection();
        $this->coAuthors = new ArrayCollection();
        $this->userFeedback = new ArrayCollection();
        $this->trainingParticipants = new ArrayCollection();
     }
  

      /**
     * @return Collection|Review[]
     */
    public function getDirectorateOfficeUsers(): Collection
    {
        return $this->directorateOfficeUsers;
    }

    public function addDirectorateOfficeUser(DirectorateOfficeUser $directorateOfficeUser): self
    {
        if (!$this->directorateOfficeUsers->contains($directorateOfficeUser)) {
            $this->directorateOfficeUsers[] = $directorateOfficeUser;
            $directorateOfficeUser->setDirectorate($this);
        }

        return $this;
    }

    public function removeDirectorateOfficeUser(DirectorateOfficeUser $directorateOfficeUser): self
    {
        if ($this->directorateOfficeUsers->removeElement($directorateOfficeUser)) {
            // set the owning side to null (unless already changed)
            if ($directorateOfficeUser->getDirectorate() === $this) {
                $directorateOfficeUser->setDirectorate(null);
            }
        }

        return $this;
    }

    public function getLastLoginAgo()
    {

        if ($this->lastLogin)
            return $this->getTimeElapsed($this->lastLogin->format('Y-m-d H:i:s'));
        return "hasn't signed in";
    }
    public function getTimeElapsed($datetime, $full = false)
    {
        $now = new \DateTime;
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    function __toString()
    {
  
          return "".$this->userInfo;
    }
  
    

 

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }
#    public function getUsername(): string
 #   {
 #       return (string) $this->username;
  //  }

    public function setUsername(string $username): self
    {
      $this->username = $username;
      return $this;
 }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getEmail(): string
    {
        return (string) $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles; 
        $roles[] = 'ROLE_USER'; 

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
       
        $this->roles = $roles;

        return $this;
    }

 

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


        /**
     * Add permission.
     *
     * @param \App\Entity\Permission $permission
     *
     * @return User
     */
    public function addPermission(Permission $permission)
    {
        $this->permissions[] = $permission;

        return $this;
    }
    
 
    /**
     * Remove permission.
     *
     * @param \App\Entity\Permission  $permission
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePermission(Permission $permission)
    {
        return $this->permissions->removeElement($permission);
    }

    /**
     * Get permissions.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPermissions()
    {
        return $this->permissions;
    }
  

   

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection|Proposal[]
     */
    public function getProposals(): Collection
    {
        return $this->proposals;
    }

    public function addProposal(Proposal $proposal): self
    {
        if (!$this->proposals->contains($proposal)) {
            $this->proposals[] = $proposal;
            $proposal->setAuthor($this);
        }

        return $this;
    }

    public function removeProposal(Proposal $proposal): self
    {
        if ($this->proposals->removeElement($proposal)) {
            // set the owning side to null (unless already changed)
            if ($proposal->getAuthor() === $this) {
                $proposal->setAuthor(null);
            }
        }

        return $this;
    }
 
   

    /**
     * @return Collection|InstitutionalReviewersBoard[]
     */
    public function getInstitutionalReviewersBoards(): Collection
    {
        return $this->institutionalReviewersBoards;
    }

    public function addInstitutionalReviewersBoard(InstitutionalReviewersBoard $institutionalReviewersBoard): self
    {
        if (!$this->institutionalReviewersBoards->contains($institutionalReviewersBoard)) {
            $this->institutionalReviewersBoards[] = $institutionalReviewersBoard;
            $institutionalReviewersBoard->setReviewer($this);
        }

        return $this;
    }

    public function removeInstitutionalReviewersBoard(InstitutionalReviewersBoard $institutionalReviewersBoard): self
    {
        if ($this->institutionalReviewersBoards->removeElement($institutionalReviewersBoard)) {
            // set the owning side to null (unless already changed)
            if ($institutionalReviewersBoard->getReviewer() === $this) {
                $institutionalReviewersBoard->setReviewer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ReviewAssignment[]
     */
    public function getReviewAssignments(): Collection
    {
        return $this->reviewAssignments;
    }

    public function addReviewAssignment(ReviewAssignment $reviewAssignment): self
    {
        if (!$this->reviewAssignments->contains($reviewAssignment)) {
            $this->reviewAssignments[] = $reviewAssignment;
            $reviewAssignment->setReviewer($this);
        }

        return $this;
    }

    public function removeReviewAssignment(ReviewAssignment $reviewAssignment): self
    {
        if ($this->reviewAssignments->removeElement($reviewAssignment)) {
            // set the owning side to null (unless already changed)
            if ($reviewAssignment->getReviewer() === $this) {
                $reviewAssignment->setReviewer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|InstitutionalReviewersBoard[]
     */
    public function getIRBMember(): Collection
    {
        return $this->i_r_b_member;
    }

    public function addIRBMember(InstitutionalReviewersBoard $iRBMember): self
    {
        if (!$this->i_r_b_member->contains($iRBMember)) {
            $this->i_r_b_member[] = $iRBMember;
            $iRBMember->setName($this);
        }

        return $this;
    }

    public function removeIRBMember(InstitutionalReviewersBoard $iRBMember): self
    {
        if ($this->i_r_b_member->removeElement($iRBMember)) {
            // set the owning side to null (unless already changed)
            if ($iRBMember->getName() === $this) {
                $iRBMember->setName(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EditorialDecision[]
     */
    public function getEditorialDecisions(): Collection
    {
        return $this->editorialDecisions;
    }
    

      /**
     * @return Collection|Submission[]
     */
    public function getSubmissions(): Collection
    {
        return $this->submissions;
    }
     
    

    public function addEditorialDecision(EditorialDecision $editorialDecision): self
    {
        if (!$this->editorialDecisions->contains($editorialDecision)) {
            $this->editorialDecisions[] = $editorialDecision;
            $editorialDecision->setEditedBy($this);
        }

        return $this;
    }

    public function removeEditorialDecision(EditorialDecision $editorialDecision): self
    {
        if ($this->editorialDecisions->removeElement($editorialDecision)) {
            // set the owning side to null (unless already changed)
            if ($editorialDecision->getEditedBy() === $this) {
                $editorialDecision->setEditedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CallForProposal[]
     */
    public function getCallForProposals(): Collection
    {
        return $this->callForProposals;
    }

    public function addCallForProposal(CallForProposal $callForProposal): self
    {
        if (!$this->callForProposals->contains($callForProposal)) {
            $this->callForProposals[] = $callForProposal;
            $callForProposal->setApprovedBy($this);
        }

        return $this;
    }

    public function removeCallForProposal(CallForProposal $callForProposal): self
    {
        if ($this->callForProposals->removeElement($callForProposal)) {
            // set the owning side to null (unless already changed)
            if ($callForProposal->getApprovedBy() === $this) {
                $callForProposal->setApprovedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Subscription[]
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    public function addSubscription(Subscription $subscription): self
    {
        if (!$this->subscriptions->contains($subscription)) {
            $this->subscriptions[] = $subscription;
            $subscription->setUser($this);
        }

        return $this;
    }

    public function removeSubscription(Subscription $subscription): self
    {
        if ($this->subscriptions->removeElement($subscription)) {
            // set the owning side to null (unless already changed)
            if ($subscription->getUser() === $this) {
                $subscription->setUser(null);
            }
        }

        return $this;
    }
    
    
    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setReviewedBy($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getReviewedBy() === $this) {
                $review->setReviewedBy(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|Announcement[]
     */
    public function getAnnouncements(): Collection
    {
        return $this->announcements;
    }

    public function addAnnouncement(Announcement $announcement): self
    {
        if (!$this->announcements->contains($announcement)) {
            $this->announcements[] = $announcement;
            $announcement->setPostedBy($this);
        }

        return $this;
    }

    public function removeAnnouncement(Announcement $announcement): self
    {
        if ($this->announcements->removeElement($announcement)) {
            // set the owning side to null (unless already changed)
            if ($announcement->getPostedBy() === $this) {
                $announcement->setPostedBy(null);
            }
        }

        return $this;
    }
     /**
     * @return Collection|UserGroup[]
     */
    public function getUserGroup(): Collection
    {
        return $this->userGroup;
    }

    public function addUserGroup(UserGroup $userGroup): self
    {
        if (!$this->userGroup->contains($userGroup)) {
            $this->userGroup[] = $userGroup;
        }

        return $this;
    }

    public function removeUserGroup(UserGroup $userGroup): self
    {
        $this->userGroup->removeElement($userGroup);

        return $this;
    }

    public function getIsSuperAdmin(): ?bool
    {
        return $this->isSuperAdmin;
    }

    public function setIsSuperAdmin(bool $isSuperAdmin): self
    {
        $this->isSuperAdmin = $isSuperAdmin;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getRegisteredAt(): ?\DateTimeInterface
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(\DateTimeInterface $registeredAt): self
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    public function getUserInfo(): ?UserInfo
    {
        return $this->userInfo;
    }

    public function setUserInfo(UserInfo $userInfo): self
    {
        // set the owning side of the relation if necessary
        if ($userInfo->getUser() !== $this) {
            $userInfo->setUser($this);
        }

        $this->userInfo = $userInfo;

        return $this;
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
            $coAuthor->setResearcher($this);
        }

        return $this;
    }

    public function removeCoAuthor(CoAuthor $coAuthor): self
    {
        if ($this->coAuthors->removeElement($coAuthor)) {
            // set the owning side to null (unless already changed)
            if ($coAuthor->getResearcher() === $this) {
                $coAuthor->setResearcher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserFeedback[]
     */
    public function getUserFeedback(): Collection
    {
        return $this->userFeedback;
    }

    public function addUserFeedback(UserFeedback $userFeedback): self
    {
        if (!$this->userFeedback->contains($userFeedback)) {
            $this->userFeedback[] = $userFeedback;
            $userFeedback->setUser($this);
        }

        return $this;
    }

    public function removeUserFeedback(UserFeedback $userFeedback): self
    {
        if ($this->userFeedback->removeElement($userFeedback)) {
            // set the owning side to null (unless already changed)
            if ($userFeedback->getUser() === $this) {
                $userFeedback->setUser(null);
            }
        }

        return $this;
    }

    public function getIsReviewer(): ?bool
    {
        return $this->is_reviewer;
    }

    public function setIsReviewer(?bool $is_reviewer): self
    {
        $this->is_reviewer = $is_reviewer;

        return $this;
    }

    /**
     * @return Collection|TrainingParticipant[]
     */
    public function getTrainingParticipants(): Collection
    {
        return $this->trainingParticipants;
    }

    public function addTrainingParticipant(TrainingParticipant $trainingParticipant): self
    {
        if (!$this->trainingParticipants->contains($trainingParticipant)) {
            $this->trainingParticipants[] = $trainingParticipant;
            $trainingParticipant->setParticipant($this);
        }

        return $this;
    }

    public function removeTrainingParticipant(TrainingParticipant $trainingParticipant): self
    {
        if ($this->trainingParticipants->removeElement($trainingParticipant)) {
            // set the owning side to null (unless already changed)
            if ($trainingParticipant->getParticipant() === $this) {
                $trainingParticipant->setParticipant(null);
            }
        }

        return $this;
    }

 

     

  
}
