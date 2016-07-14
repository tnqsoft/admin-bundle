<?php

namespace TNQSoft\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use TNQSoft\AdminBundle\Entity\ProductImg;
use TNQSoft\AdminBundle\Entity\ProductCategory;
use TNQSoft\AdminBundle\Entity\Partner;
use TNQSoft\AdminBundle\Entity\Sale;

/**
 * @ORM\Table(name="product")
 * @ORM\Entity
 * @UniqueEntity(fields="upc", message="UPC already taken")
 * @ORM\HasLifecycleCallbacks()
 */
class Product
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=false, options={"comment":"Universal Product Code"})
     * @Assert\NotBlank()
     */
    private $upc;

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
     * @ORM\Column(type="text", nullable=false)
     * @Assert\NotBlank()
     */
    private $content;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $price;

    /**
     * @ORM\Column(name="out_of_stock", type="boolean", nullable=false)
     */
    private $outOfStock;

    /**
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    private $isActive;

    /**
     * @ORM\Column(name="is_new", type="boolean", nullable=false)
     */
    private $isNew;

    /**
     * @ORM\Column(name="is_special", type="boolean", nullable=false)
     */
    private $isSpecial;

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
     * @var ProductCategory
     *
     * @ORM\ManyToOne(targetEntity="ProductCategory", inversedBy="listProduct")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var Partner
     *
     * @ORM\ManyToOne(targetEntity="Partner", inversedBy="listProduct")
     * @ORM\JoinColumn(name="partner_id", referencedColumnName="id")
     */
    private $partner;

    /**
     * @ORM\OneToMany(targetEntity="ProductImg", mappedBy="product", cascade={"all"})
     */
    protected $listPhoto;

    /**
     * @ORM\Column(name="view_number", type="integer", nullable=true, options={"default" = 0})
     */
    protected $viewNumber;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Sale", inversedBy="products")
     * @ORM\JoinTable(name="product_sale")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    protected $sales;

    public function __construct()
    {
        $this->isActive = true;
        $this->isNew = false;
        $this->isSpecial = false;
        $this->outOfStock = true;
        $this->listPhoto = new ArrayCollection();
        $this->sales = new ArrayCollection();
        $this->price = 0;
    }

    public function __toString()
    {
        return '('.$this->getUpc().') '.$this->getTitle();
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
     * Get the value of Upc
     *
     * @return mixed
     */
    public function getUpc()
    {
        return $this->upc;
    }

    /**
     * Set the value of Upc
     *
     * @param mixed upc
     *
     * @return self
     */
    public function setUpc($upc)
    {
        $this->upc = $upc;

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
     * Get the value of Content
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of Content
     *
     * @param mixed content
     *
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of Price
     *
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of Price
     *
     * @param mixed price
     *
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of Out Of Stock
     *
     * @return mixed
     */
    public function getOutOfStock()
    {
        return $this->outOfStock;
    }

    /**
     * Set the value of Out Of Stock
     *
     * @param mixed outOfStock
     *
     * @return self
     */
    public function setOutOfStock($outOfStock)
    {
        $this->outOfStock = $outOfStock;

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
     * Get the value of Is New
     *
     * @return mixed
     */
    public function getIsNew()
    {
        return $this->isNew;
    }

    /**
     * Set the value of Is New
     *
     * @param mixed isNew
     *
     * @return self
     */
    public function setIsNew($isNew)
    {
        $this->isNew = $isNew;

        return $this;
    }

    /**
     * Get the value of Is Special
     *
     * @return mixed
     */
    public function getIsSpecial()
    {
        return $this->isSpecial;
    }

    /**
     * Set the value of Is Special
     *
     * @param mixed isSpecial
     *
     * @return self
     */
    public function setIsSpecial($isSpecial)
    {
        $this->isSpecial = $isSpecial;

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
     * Get the value of Category
     *
     * @return ProductCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of Category
     *
     * @param ProductCategory category
     *
     * @return self
     */
    public function setCategory(ProductCategory $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get the value of Partner
     *
     * @return Partner
     */
    public function getPartner()
    {
        return $this->partner;
    }

    /**
     * Set the value of Partner
     *
     * @param Partner partner
     *
     * @return self
     */
    public function setPartner(Partner $partner)
    {
        $this->partner = $partner;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getViewNumber()
    {
        return $this->viewNumber;
    }

    /**
     * @param mixed $viewNumber
     * @return Product
     */
    public function setViewNumber($viewNumber)
    {
        $this->viewNumber = $viewNumber;
        return $this;
    }

    /**
     * Add list photo
     *
     * @param  ProductImg $photo
     * @return Product
     */
    public function addListPhoto(ProductImg $photo) {
        $photo->setProduct($this);
        $this->listPhoto->add($photo);

        return $this;
    }

    /**
     * Removes list photo.
     *
     * @param  ProductImg $photo
     * @return Product
     */
    public function removeListPhoto(ProductImg $photo) {
        $this->listPhoto->removeElement($photo);
        return $this;
    }

    /**
     * Clear all photo
     *
     * @return Product
     */
    public function clearListPhoto() {
        $this->listPhoto->clear();

        return $this;
    }

    /**
     * Has Photo
     *
     * @param  ProductImg $photo
     * @return booleans
     */
    public function hasPhoto(ProductImg $photo) {
        return $this->listPhoto->contains($photo);
    }


    /**
     * Get the value of List Photo
     *
     * @return mixed
     */
    public function getListPhoto()
    {
        return $this->listPhoto;
    }

    /**
     * Set the value of List Photo
     *
     * @param mixed listPhoto
     *
     * @return self
     */
    public function setListPhoto($listPhoto)
    {
        $this->listPhoto = $listPhoto;

        return $this;
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
     * @return ArrayCollection
     */
    public function getSales()
    {
        return $this->sales;
    }

    /**
     * @param ArrayCollection $sales
     * @return Product
     */
    public function setSales(ArrayCollection $sales)
    {
        $this->sales = $sales;
        return $this;
    }

    /**
     * Clear all Sales
     *
     * @return Product
     */
    public function clearSales() {
        $this->sales->clear();

        return $this;
    }

    /**
     * Has Sale
     *
     * @param  Sale $sale
     * @return booleans
     */
    public function hasSale(Sale $sale) {
        return $this->sales->contains($sale);
    }

    /**
     * Add Sale
     *
     * @param Sale $sale
     */
    public function addSale(Sale $sale)
    {
        if ( !$this->hasSale($sale) ) {
            $this->sales[] = $sale;
            $sale->addProduct($this);
        }
    }

    /**
     * Remove Sale With Product
     *
     * @param  Sale $sale
     */
    public function removeSaleWithProduct(Sale $sale)
    {
        $this->sales->removeElement($sale);
        $sale->removeProduct($this);
    }

    /**
     * Remove Sale
     *
     * @param  Sale $sale
     */
    public function removeSale(Sale $sale)
    {
        $this->sales->removeElement($sale);
    }

    /**
     * Get SaleOff by active Sale
     *
     * @return integer
     */
    public function getSaleOff()
    {
        $activeSaleOff = $this->getActiveSaleOff();
        if(null !== $activeSaleOff) {
            return $activeSaleOff->getPercentage();
        }
        return -1;
    }

    /**
     * Get Price SaleOff by active Sale
     *
     * @return float
     */
    public function getPriceSaleOff()
    {
        if($this->getPrice() <= 0) {
            return 0;
        }
        $activeSaleOff = $this->getActiveSaleOff();
        if(null !== $activeSaleOff) {
            $percentage = $activeSaleOff->getPercentage();
            return $this->getPrice() - (($this->getPrice()*$percentage)/100);
        }
        return 0;
    }

    /**
     * Get Active SaleOff By Begin and End date
     *
     * @return Sale
     */
    public function getActiveSaleOff()
    {
        $now = new \DateTime();
        foreach($this->sales as $sale) {
            if($sale->getBeginDate() <= $now && $sale->getEndDate() >= $now && $sale->getIsActive() === true) {
                return $sale;
            }
        }

        return null;
    }
}
