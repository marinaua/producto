<?php
namespace Producto;

use Producto\Entity\EntityInterface;

class ProcessedData
{
    /** @var  int */
    private $bundlesNumber = 0;

    /** @var  int */
    private $productsNumber = 0;

    /** @var  int */
    private $availableProductsNumber = 0;

    /** @var  int */
    private $validBundlesNumber = 0;

    /** @var  EntityInterface[] */
    private $items;

    /**
     * Total number of read items (excluding discarded)
     *
     * @return int
     */
    public function getItemsNumber()
    {
        return count($this->items);
    }

    /**
     * Get number of items of type "PRODUCT"
     *
     * @return int
     */
    public function getProductsNumber()
    {
        return $this->productsNumber;
    }

    /**
     * Get number of items of type "BUNDLE"
     *
     * @return int
     */
    public function getBundlesNumber()
    {
        return $this->bundlesNumber;
    }

    /**
     * Get number of unavailable (non-sellable) items of type "PRODUCT" (quantity is 0)
     *
     * @return int
     */
    public function getUnavailableProductsNumber()
    {
        return $this->productsNumber - $this->availableProductsNumber;
    }

    /**
     * Number of invalid items of type "BUNDLE"
     *
     * @return int
     */
    public function getInvalidBundlesNumber()
    {
        return $this->bundlesNumber - $this->validBundlesNumber;
    }

    /**
     * Total number of available (sellable) items
     *
     * @return int
     */
    public function getAvailableItemsNumber()
    {
        return $this->availableProductsNumber + $this->validBundlesNumber;
    }

    /**
     * Increment available (sellable) products number
     */
    public function incrementAvailableProductsNumber()
    {
        $this->availableProductsNumber++;
    }

    /**
     * Increment valid bundles number
     */
    public function incrementValidBundlesNumber()
    {
        $this->validBundlesNumber++;
    }

    /**
     * Increment products number
     */
    public function incrementProductsNumber()
    {
        $this->productsNumber++;
    }

    /**
     * Increment bundles number
     */
    public function incrementBundlesNumber()
    {
        $this->bundlesNumber++;
    }

    /**
     * Add item to list
     *
     * @param EntityInterface $item
     */
    public function addItem(EntityInterface $item)
    {
        $this->items[] = $item;
    }

    /**
     * @param $lineNumber
     *
     * @return EntityInterface
     * @throws \Exception
     */
    public function getItemByLineNumber($lineNumber)
    {
        if (false === array_key_exists($lineNumber, $this->items)) {
            throw new \Exception("PRODUCT NUMBER OUT OF RANGE");
        }

        if (false === $this->items[$lineNumber]->isAvailable()) {
            throw new \Exception("INVALID PRODUCT SELECTED");
        }

        return $this->items[$lineNumber];
    }
}