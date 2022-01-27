<?php

namespace App\Entity;

use App\Repository\SubscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubscriptionRepository::class)
 */
class Subscription
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="subscriptions")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $calls;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $news;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $new_submission;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $announcement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

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

    public function getCalls(): ?bool
    {
        return $this->calls;
    }

    public function setCalls(?bool $calls): self
    {
        $this->calls = $calls;

        return $this;
    }

    public function getNews(): ?bool
    {
        return $this->news;
    }

    public function setNews(?bool $news): self
    {
        $this->news = $news;

        return $this;
    }

    public function getNewSubmission(): ?bool
    {
        return $this->new_submission;
    }

    public function setNewSubmission(?bool $new_submission): self
    {
        $this->new_submission = $new_submission;

        return $this;
    }

    public function getAnnouncement(): ?bool
    {
        return $this->announcement;
    }

    public function setAnnouncement(?bool $announcement): self
    {
        $this->announcement = $announcement;

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
}
