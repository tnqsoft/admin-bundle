<?php

namespace TNQSoft\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use TNQSoft\AdminBundle\Entity\Photo;

/**
 * @ORM\Table(name="photo_category")
 * @ORM\Entity
 * @UniqueEntity(fields="slug", message="Slug already taken")
 * @ORM\HasLifecycleCallbacks()
 */
class PhotoCategory
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     * @Assert\NotBlank()
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=65535, nullable=true)
     */
    private $summary;

    /**
     * @ORM\Column(name="meta_keywords", type="string", length=65535, nullable=true)
     */
    protected $metaKeywords;

    /**
     * @ORM\Column(name="meta_description", type="string", length=65535, nullable=true)
     */
    protected $metaDescription;

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
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="category", cascade={"all"})
     */
    protected $listPhoto;

    public function __construct()
    {
        $this->isActive = true;
        $this->listPhoto = new ArrayCollection();
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
     * Get the value of Slug
     *
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the value of Slug
     *
     * @param mixed slug
     *
     * @return self
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
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
     * Get the value of Summary
     *
     * @return mixed
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set the value of Summary
     *
     * @param mixed summary
     *
     * @return self
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

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
     * Add list photo
     *
     * @param  Photo $photo
     * @return PhotoCategory
     */
    public function addListPhoto(Photo $photo) {
        $photo->setCategory($this);
        $this->listPhoto->add($photo);

        return $this;
    }

    /**
     * Removes list photo.
     *
     * @param  Photo $photo
     * @return PhotoCategory
     */
    public function removeListPhoto(Photo $photo) {
        $this->listPhoto->removeElement($photo);

        return $this;
    }

    /**
     * Clear all photo
     *
     * @return PhotoCategory
     */
    public function clearListPhoto() {
        $this->listPhoto->clear();

        return $this;
    }

    /**
     * Has Photo
     *
     * @param  Photo $photo
     * @return booleans
     */
    public function hasPhoto(Photo $photo) {
        return $this->listPhoto->contains($photo);
    }

    public function getListPhoto() {
        return $this->listPhoto;
    }

    /**
     * Get Web Path by Photo Default
     *
     * @return string
     */
    public function getWebPath()
    {
        $photoDefault = null;
        if(!empty($this->getListPhoto())) {
            foreach ($this->getListPhoto() as $photo) {
                if($photo->getIsDefault() === true) {
                    $photoDefault = $photo;
                    break;
                }
            }
        }

        return null === $photoDefault
            ? null
            : $photoDefault->getWebPath();
    }

    /**
     * @return mixed
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * @param mixed $metaKeywords
     * @return PhotoCategory
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * @param mixed $metaDescription
     * @return PhotoCategory
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;
        return $this;
    }
}
