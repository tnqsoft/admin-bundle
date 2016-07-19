<?php

namespace TNQSoft\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="user_group")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class UserGroup
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
     * @ORM\OneToMany(targetEntity="User", mappedBy="group")
     */
    protected $users;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="UserRole", inversedBy="groups")
     * @ORM\JoinTable(name="user_group_role")
     */
    protected $roles;

    public function __construct()
    {
        $this->isActive = true;
        $this->users = new ArrayCollection();
        $this->roles = new ArrayCollection();
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
     * @return self
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
     * @return self
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
     * Add list User
     *
     * @param  User $name
     * @return self
     */
    public function addUser(User $user) {
        if ( !$this->hasUser($user) ) {
            $this->users[] = $user;
        }

        return $this;
    }

    /**
     * Removes list user.
     *
     * @param  User $user
     * @return self
     */
    public function removeUser(User $user) {
        $this->users->removeElement($user);

        return $this;
    }

    /**
     * Has User
     *
     * @param  User $user
     * @return booleans
     */
    public function hasUser(User $user) {
        return $this->users->contains($user);
    }

    /**
     * Clear all user
     *
     * @return self
     */
    public function clearUsers() {
        foreach ($this->users as $user) {
            $this->removeUser($user);
        }
        $this->users->clear();

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param ArrayCollection $roles
     * @return self
     */
    public function setRoles(ArrayCollection $roles)
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * Clear all Roles
     *
     * @return self
     */
    public function clearRoles() {
        foreach ($this->roles as $role) {
            $this->removeRoleWithGroup($role);
        }
        $this->roles->clear();

        return $this;
    }

    /**
     * Has Role
     *
     * @param  UserRole $role
     * @return booleans
     */
    public function hasRole(UserRole $role) {
        return $this->roles->contains($role);
    }

    /**
     * Add Role
     *
     * @param UserRole $role
     */
    public function addRole(UserRole $role)
    {
        if ( !$this->hasRole($role) ) {
            $this->roles[] = $role;
            $role->addGroup($this);
        }
    }

    /**
     * Remove Role With Group
     *
     * @param  UserRole $role
     */
    public function removeRoleWithGroup(UserRole $role)
    {
        $this->roles->removeElement($role);
        $role->removeGroup($this);
    }

    /**
     * Remove Role
     *
     * @param  UserRole $role
     */
    public function removeRole(UserRole $role)
    {
        $this->roles->removeElement($role);
    }
}
