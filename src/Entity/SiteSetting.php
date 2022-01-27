<?php

namespace App\Entity;

use App\Repository\SiteSettingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SiteSettingRepository::class)
 */
class SiteSetting
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prefix;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contact_address;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $about;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $privacy_statement;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $app_description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $organization;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $app_url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $corporate_color;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $motto;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $copyright;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $site_logo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $navbar_background;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $acronym;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $route;

    /**
     * @ORM\OneToMany(targetEntity=BackupSetting::class, mappedBy="site")
     */
    private $backupSettings;

    public function __construct()
    {
        $this->backupSettings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
        public function __toString(): string
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

 public function setId( ): self
   {
          $this->id = 1;
  
          return $this;
      }
    
    public function setPrefix(?string $prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function getContactAddress(): ?string
    {
        return $this->contact_address;
    }

    public function setContactAddress(?string $contact_address): self
    {
        $this->contact_address = $contact_address;

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(?string $about): self
    {
        $this->about = $about;

        return $this;
    }

    public function getPrivacyStatement(): ?string
    {
        return $this->privacy_statement;
    }

    public function setPrivacyStatement(?string $privacy_statement): self
    {
        $this->privacy_statement = $privacy_statement;

        return $this;
    }

    public function getAppDescription(): ?string
    {
        return $this->app_description;
    }

    public function setAppDescription(?string $app_description): self
    {
        $this->app_description = $app_description;

        return $this;
    }

    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    public function setOrganization(?string $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    public function getAppUrl(): ?string
    {
        return $this->app_url;
    }

    public function setAppUrl(?string $app_url): self
    {
        $this->app_url = $app_url;

        return $this;
    }

    public function getCorporateColor(): ?string
    {
        return $this->corporate_color;
    }

    public function setCorporateColor(?string $corporate_color): self
    {
        $this->corporate_color = $corporate_color;

        return $this;
    }

    public function getMotto(): ?string
    {
        return $this->motto;
    }

    public function setMotto(?string $motto): self
    {
        $this->motto = $motto;

        return $this;
    }

    public function getCopyright(): ?string
    {
        return $this->copyright;
    }

    public function setCopyright(?string $copyright): self
    {
        $this->copyright = $copyright;

        return $this;
    }

    public function getSiteLogo(): ?string
    {
        return $this->site_logo;
    }

    public function setSiteLogo(?string $site_logo): self
    {
        $this->site_logo = $site_logo;

        return $this;
    }

    public function getNavbarBackground(): ?string
    {
        return $this->navbar_background;
    }

    public function setNavbarBackground(?string $navbar_background): self
    {
        $this->navbar_background = $navbar_background;

        return $this;
    }

    public function getAcronym(): ?string
    {
        return $this->acronym;
    }

    public function setAcronym(?string $acronym): self
    {
        $this->acronym = $acronym;

        return $this;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(?string $manage): self
    {
        $this->route = $manage= 'manage';

        return $this;
    }

    /**
     * @return Collection|BackupSetting[]
     */
    public function getBackupSettings(): Collection
    {
        return $this->backupSettings;
    }

    public function addBackupSetting(BackupSetting $backupSetting): self
    {
        if (!$this->backupSettings->contains($backupSetting)) {
            $this->backupSettings[] = $backupSetting;
            $backupSetting->setSite($this);
        }

        return $this;
    }

    public function removeBackupSetting(BackupSetting $backupSetting): self
    {
        if ($this->backupSettings->removeElement($backupSetting)) {
            // set the owning side to null (unless already changed)
            if ($backupSetting->getSite() === $this) {
                $backupSetting->setSite(null);
            }
        }

        return $this;
    }
}
