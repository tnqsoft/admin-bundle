<?php

namespace TNQSoft\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="user_role")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class UserRole
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(name="description", type="string", length=65535, nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    private $isActive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="UserRolePermission", mappedBy="role")
     */
    protected $permissions;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="UserGroup", mappedBy="roles")
     */
    protected $groups;

    public function __construct()
    {
        $this->isActive = true;
        $this->permissions = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
    }

    /**
     * Get the value of Id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of Title
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of Title
     *
     * @param mixed title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get the value of Is Active
     *
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set the value of Is Active
     *
     * @param mixed isActive
     *
     * @return self
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Set createdAt
     *
     * @ORM\PrePersist
     * @return Customer
     */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime();

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @ORM\PreUpdate
     * @return Customer
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime();

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add list Permissions
     *
     * @param  UserRolePermission $permission
     * @return self
     */
    public function addPermission(UserRolePermission $permission) {
        if ( !$this->hasPermission($permission) ) {
            $this->permissions[] = $permission;
        }

        return $this;
    }

    /**
     * Removes list permission.
     *
     * @param  UserRolePermission $permission
     * @return self
     */
    public function removePermission(UserRolePermission $permission) {
        $this->permissions->removeElement($permission);

        return $this;
    }

    /**
     * Has Permission
     *
     * @param  UserRolePermission $permission
     * @return booleans
     */
    public function hasPermission(UserRolePermission $permission) {
        return $this->permissions->contains($permission);
    }

    /**
     * Clear all permission
     *
     * @return self
     */
    public function clearPermissions() {
        foreach ($this->permissions as $permission) {
            $this->removePermission($permission);
        }
        $this->permissions->clear();

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param ArrayCollection $groups
     * @return self
     */
    public function setProducts(ArrayCollection $groups)
    {
        $this->groups = $groups;
        return $this;
    }

    /**
     * Clear all Groups
     *
     * @return self
     */
    public function clearGroups() {
        foreach ($this->groups as $group) {
            $this->removeGroupWithRole($group);
        }
        $this->groups->clear();

        return $this;
    }

    /**
     * Has Group
     *
     * @param  UserGroup $group
     * @return booleans
     */
    public function hasGroup(UserGroup $group) {
        return $this->groups->contains($group);
    }

    /**
     * @param UserGroup $group
     */
    public function addGroup(UserGroup $group)
    {
        if ( !$this->hasGroup($group) ) {
            $this->groups[] = $group;
            $group->addRole($this);
        }
    }

    /**
     * @param UserGroup $group
     */
    public function removeGroup(UserGroup $group)
    {
        $this->groups->removeElement($group);
    }

    /**
     * @param UserGroup $group
     */
    public function removeGroupWithRole(UserGroup $group)
    {
        $this->groups->removeElement($group);
        $group->removeRole($this);
    }
}
