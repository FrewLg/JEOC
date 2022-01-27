<?php

namespace App\Entity;

use App\Repository\AnnouncementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnnouncementRepository::class)
 */
class Announcement
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
    private $subject;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $body;

    /**
     * @ORM\Column(type="string", length=255 , nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $poseted_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="announcements")
     */
    private $posted_by;

    /**
     * @ORM\Column(type="datetime")
     */
    private $openAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $closeAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPosted=0;

   
  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

   function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getId();
    }


    
public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPosetedAt(): ?\DateTimeInterface
    {
        return $this->poseted_at;
    }

    public function setPosetedAt(?\DateTimeInterface $poseted_at): self
    {
        $this->poseted_at = $poseted_at;

        return $this;
    }

    public function getPostedBy(): ?User
    {
        return $this->posted_by;
    }

    public function setPostedBy(?User $posted_by): self
    {
        $this->posted_by = $posted_by;

        return $this;
    }

    public function getOpenAt(): ?\DateTimeInterface
    {
        return $this->openAt;
    }

    public function setOpenAt(\DateTimeInterface $openAt): self
    {
        $this->openAt = $openAt;

        return $this;
    }

    public function getCloseAt(): ?\DateTimeInterface
    {
        return $this->closeAt;
    }

    public function setCloseAt(\DateTimeInterface $closeAt): self
    {
        $this->closeAt = $closeAt;

        return $this;
    }

    public function getIsPosted(): ?bool
    {
        return $this->isPosted;
    }

    public function setIsPosted(bool $isPosted): self
    {
        $this->isPosted = $isPosted;

        return $this;
    }

    
}
