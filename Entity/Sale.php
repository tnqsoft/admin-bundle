<?php

namespace TNQSoft\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use TNQSoft\CommonBundle\Validator\Constraints\CompareWithField;
use TNQSoft\AdminBundle\Entity\Product;

/**
 * @ORM\Table(name="sale")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Sale
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
     * @ORM\Column(type="integer", nullable=false)
     */
    private $percentage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="begin_date", type="datetime", nullable=false)
     * @Assert\DateTime()
     */
    private $beginDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=false)
     * @Assert\DateTime()
     * @CompareWithField(field="beginDate", operator=">=", message="Ngày kết thúc cần lớn hơn ngày bắt đầu.")
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", length=65535, nullable=true)
     */
    private $description;

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
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="sales")
     */
    protected $products;

    /**
     * @var string
     */
    protected $productsId;

    public function __construct()
    {
        $this->isActive = true;
        $this->beginDate = new \DateTime();
        $this->endDate = new \DateTime();
        $this->percentage = 10;
        $this->products = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTitle();
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
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return ProductSale
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * @param mixed $percentage
     * @return ProductSale
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBeginDate()
    {
        return $this->beginDate;
    }

    /**
     * @param \DateTime $beginDate
     * @return ProductSale
     */
    public function setBeginDate($beginDate)
    {
        $this->beginDate = $beginDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     * @return ProductSale
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
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
     * @return ProductSale
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
     * @return ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param ArrayCollection $products
     * @return Sale
     */
    public function setProducts(ArrayCollection $products)
    {
        $this->products = $products;
        return $this;
    }

    /**
     * Clear all Products
     *
     * @return Sale
     */
    public function clearProducts() {
        $this->products->clear();

        return $this;
    }

    /**
     * Has Product
     *
     * @param  Product $product
     * @return booleans
     */
    public function hasProduct(Product $product) {
        return $this->products->contains($product);
    }

    public function addProduct(Product $product)
    {
        if ( !$this->hasProduct($product) ) {
            $this->products[] = $product;
            $product->addTheme($this);
        }
    }

    public function removeProduct(Product $product)
    {
        $this->products->removeElement($product);
        $product->removeSale($this);
    }

    public function getProductsId()
    {
        $tmp = array();
        foreach($this->products as $product) {
            $tmp[] = $product->getId();
        }
        $this->productsId = implode(',', $tmp);

        return $this->productsId;
    }

    public function setProductsId($ids)
    {
        $this->productsId = $ids;

        return $this;
    }
}
