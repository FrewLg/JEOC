<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="`group`")
 */
class Group
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
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="groups")
     */
    private $users_groups;

    /**
     * @ORM\ManyToMany(targetEntity=Permission::class, mappedBy="groups")
     */
    private $permissions;

    public function __construct()
    {
        $this->users_groups = new ArrayCollection();
        $this->permissions = new ArrayCollection();
    }

    public function getId(): ?int
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
   function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getName();
    }
    /**
     * @return Collection|User[]
     */
    public function getUsersGroups(): Collection
    {
        return $this->users_groups;
    }

    public function addUsersGroup(User $usersGroup): self
    {
        if (!$this->users_groups->contains($usersGroup)) {
            $this->users_groups[] = $usersGroup;
            $usersGroup->addGroup($this);
        }

        return $this;
    }

    public function removeUsersGroup(User $usersGroup): self
    {
        if ($this->users_groups->removeElement($usersGroup)) {
            $usersGroup->removeGroup($this);
        }

        return $this;
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

    public function getRoles() {
        $this->roles=array();
        $permissions = array();
        foreach ($this->getPermissions() as $permission) {
            array_push($permissions, $permission->getName());
        }
        return $this->roles = array_merge($this->roles, $permissions);
    }
    
#    /**
 #    * @return Collection|Permission[]
  #   */
#    public function getPermissions(): Collection
 #  {
  #      return $this->permissions;
   # }

    public function addPermission(Permission $permission): self
    {
        if (!$this->permissions->contains($permission)) {
            $this->permissions[] = $permission;
            $permission->addGroup($this);
        }

        return $this;
    }

    public function removePermission(Permission $permission): self
    {
        if ($this->permissions->removeElement($permission)) {
            $permission->removeGroup($this);
        }

        return $this;
    }
}
