<?php

namespace App\Entity;

use App\Repository\BackupSettingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BackupSettingRepository::class)
 */
class BackupSetting
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
    private $emailto;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emailfrom;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $email_subject;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $db_user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $db_password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $destination_dir;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logfile_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mysql_host;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $source_dir;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $remote_machine_ip;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emailto_cc;

    /**
     * @ORM\ManyToOne(targetEntity=SiteSetting::class, inversedBy="backupSettings")
     */
    private $site;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $remote_app_dir;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $remote_db_dir;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gmail_user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gmail_pass;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $email_body;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $signature;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $backup_days;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmailto(): ?string
    {
        return $this->emailto;
    }

    public function setEmailto(?string $emailto): self
    {
        $this->emailto = $emailto;

        return $this;
    }

    public function getEmailfrom(): ?string
    {
        return $this->emailfrom;
    }

    public function setEmailfrom(?string $emailfrom): self
    {
        $this->emailfrom = $emailfrom;

        return $this;
    }

    public function getEmailSubject(): ?string
    {
        return $this->email_subject;
    }

    public function setEmailSubject(?string $email_subject): self
    {
        $this->email_subject = $email_subject;
 
        return $this;
    }

    public function getDbUser(): ?string
    {
        return $this->db_user;
    }

    public function setDbUser(?string $db_user): self
    {
        $this->db_user = $db_user;

        return $this;
    }

    public function getDbPassword(): ?string
    {
        return $this->db_password;
    }

    public function setDbPassword(?string $db_password): self
    {
        $this->db_password = $db_password;

        return $this;
    }

    public function getDestinationDir(): ?string
    {
        return $this->destination_dir;
    }

    public function setDestinationDir(?string $destination_dir): self
    {
        $this->destination_dir = $destination_dir;

        return $this;
    }
            public function __toString(): string
    {
        return $this->id;
    }

    public function getLogfileName(): ?string
    {
        return $this->logfile_name;
    }

    public function setLogfileName(?string $logfile_name): self
    {
        $this->logfile_name = $logfile_name;

        return $this;
    }

    public function getMysqlHost(): ?string
    {
        return $this->mysql_host;
    }

    public function setMysqlHost(?string $mysql_host): self
    {
        $this->mysql_host = $mysql_host;

        return $this;
    }

    public function getSourceDir(): ?string
    {
        return $this->source_dir;
    }

    public function setSourceDir(?string $source_dir): self
    {
        $this->source_dir = $source_dir;

        return $this;
    }

    public function getRemoteMachineIp(): ?string
    {
        return $this->remote_machine_ip;
    }

    public function setRemoteMachineIp(?string $remote_machine_ip): self
    {
        $this->remote_machine_ip = $remote_machine_ip;

        return $this;
    }

    public function getEmailtoCc(): ?string
    {
        return $this->emailto_cc;
    }

    public function setEmailtoCc(?string $emailto_cc): self
    {
        $this->emailto_cc = $emailto_cc;

        return $this;
    }

    public function getSite(): ?SiteSetting
    {
        return $this->site;
    }

    public function setSite(?SiteSetting $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function getRemoteAppDir(): ?string
    {
        return $this->remote_app_dir;
    }

    public function setRemoteAppDir(?string $remote_app_dir): self
    {
        $this->remote_app_dir = $remote_app_dir;

        return $this;
    }

    public function getRemoteDbDir(): ?string
    {
        return $this->remote_db_dir;
    }

    public function setRemoteDbDir(?string $remote_db_dir): self
    {
        $this->remote_db_dir = $remote_db_dir;

        return $this;
    }

    public function getGmailUser(): ?string
    {
        return $this->gmail_user;
    }

    public function setGmailUser(?string $gmail_user): self
    {
        $this->gmail_user = $gmail_user;

        return $this;
    }

    public function getGmailPass(): ?string
    {
        return $this->gmail_pass;
    }

    public function setGmailPass(?string $gmail_pass): self
    {
        $this->gmail_pass = $gmail_pass;

        return $this;
    }

    public function getEmailBody(): ?string
    {
        return $this->email_body;
    }

    public function setEmailBody(?string $email_body): self
    {
        $this->email_body = $email_body;

        return $this;
    }

    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(?string $signature): self
    {
        $this->signature = $signature;

        return $this;
    }

    public function getBackupDays(): ?string
    {
        return $this->backup_days;
    }

    public function setBackupDays(?string $backup_days): self
    {
        $this->backup_days = $backup_days;

        return $this;
    }
}
