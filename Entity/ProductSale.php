<?php

namespace TNQSoft\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use TNQSoft\AdminBundle\Entity\Sale;
use TNQSoft\AdminBundle\Entity\Product;

/**
 * ProductSale
 *
 * @ORM\Table(name="product_sale", indexes={@ORM\Index(name="sale_id", columns={"sale_id"}), @ORM\Index(name="product_id", columns={"product_id"})})
 * @ORM\Entity
 */
class ProductSale
{
    /**
     * @var Sale
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Sale")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sale_id", referencedColumnName="id")
     * })
     */
    private $sale;

    /**
     * @var Product
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

    /**
     * Set Sale
     *
     * @param Sale $sale
     *
     * @return ProductSale
     */
    public function setSale(Sale $sale)
    {
        $this->sale = $sale;

        return $this;
    }

    /**
     * Get Sale
     *
     * @return Sale
     */
    public function getSale()
    {
        return $this->sale;
    }

    /**
     * Set Product
     *
     * @param Product
     *
     * @return ProductSale
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get Product
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
