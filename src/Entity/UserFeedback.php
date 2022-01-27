<?php

namespace App\Entity;

use App\Repository\UserFeedbackRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserFeedbackRepository::class)
 * @ORM\Table(name="a_users_feedback")
 */
class UserFeedback
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userFeedback")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $sent_at;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $the_feedback;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subject;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSentAt(): ?\DateTimeInterface
    {
        return $this->sent_at;
    }

    public function setSentAt(\DateTimeInterface $sent_at): self
    {
        $this->sent_at = $sent_at;

        return $this;
    }

    public function getTheFeedback(): ?string
    {
        return $this->the_feedback;
    }

    public function setTheFeedback(?string $the_feedback): self
    {
        $this->the_feedback = $the_feedback;

        return $this;
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
}
