<?php
namespace Producto\Entity;

class Product implements EntityInterface
{
    const NAME_ID = 0;
    const PRICE_ID = 1;
    const QUANTITY_ID = 2;

    /** @var  string */
    private $sku;

    /** @var  string */
    private $name;

    /** @var  float */
    private $price;

    /** @var  int */
    private $quantity;

    /** @var  boolean */
    private $available;

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param string $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param boolean $available
     */
    public function setAvailable($available)
    {
        $this->available = $available;
    }

    /**
     * @return boolean
     */
    public function isAvailable()
    {
        return $this->available;
    }
}
