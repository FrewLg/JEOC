<?php

namespace App\Entity;

use App\Repository\BackupHistoryRepository;
use Doctrine\ORM\Mapping as ORM;
 
/**
 * @ORM\Entity(repositoryClass=BackupHistoryRepository::class)
 */
class BackupHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $backup_date;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $successful;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $res_path;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $remote_ip;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBackupDate(): ?\DateTimeInterface
    {
        return $this->backup_date;
    }

    public function setBackupDate(?\DateTimeInterface $backup_date): self
    {
        $this->backup_date = $backup_date;

        return $this;
    }

    public function getSuccessful(): ?bool
    {
        return $this->successful;
    }

    public function setSuccessful(?bool $successful): self
    {
        $this->successful = $successful;

        return $this;
    }

    public function getResPath(): ?string
    {
        return $this->res_path;
    }

    public function setResPath(?string $res_path): self
    {
        $this->res_path = $res_path;

        return $this;
    }

    public function getRemoteIp(): ?string
    {
        return $this->remote_ip;
    }

    public function setRemoteIp(?string $remote_ip): self
    {
        $this->remote_ip = $remote_ip;

        return $this;
    }
}
