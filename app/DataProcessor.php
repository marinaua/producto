<?php
namespace Producto;


use Producto\Entity\Bundle;
use Producto\Entity\Product;

class DataProcessor
{
    /**
     * @param array $data
     * @return ProcessedData
     */
    public function process(array $data)
    {
        $processedData = new ProcessedData();

        $products = $data['products'];
        $bundles = $data['bundles'];

        $itemsList = $data['itemsList'];

        foreach($itemsList as $itemSku) {
            if (array_key_exists($itemSku, $products)) {
                $item = $this->prepareProductItem($itemSku, $products, $processedData);
            } else {
                $item = $this->prepareBundleItem($itemSku, $bundles, $products, $processedData);
            }

            $processedData->addItem($item);
        }

        return $processedData;
    }

    /**
     * @param string $itemSku
     * @param array $products
     * @param ProcessedData $processedData
     *
     * @return Product
     */
    private function prepareProductItem($itemSku, $products, ProcessedData $processedData)
    {
        $item = new Product();
        $item->setSku($itemSku);
        $item->setName($products[$itemSku][Product::NAME_ID]);
        $item->setPrice($products[$itemSku][Product::PRICE_ID]);
        $item->setQuantity($products[$itemSku][Product::QUANTITY_ID]);

        $isAvailable = $products[$itemSku][Product::QUANTITY_ID] > 0;

        $item->setAvailable($isAvailable);

        if ($isAvailable) {
            $processedData->incrementAvailableProductsNumber();
        }

        $processedData->incrementProductsNumber();

        return $item;
    }

    /**
     * @param string $itemSku
     * @param array $bundles
     * @param array $products
     * @param ProcessedData $processedData
     *
     * @return Bundle
     */
    private function prepareBundleItem($itemSku, $bundles, $products, ProcessedData $processedData)
    {
        $item = new Bundle();
        $item->setSku($itemSku);

        $isValid = true;

        $bundleProducts = [];

        $bundlePrice = 0.0;

        foreach ($bundles[$itemSku] as $bundleProductSku) {
            if (array_key_exists($bundleProductSku, $products)
                && $products[$bundleProductSku][Product::QUANTITY_ID] > 0
            ) {
                $bundleProduct = new Product();
                $bundleProduct->setSku($bundleProductSku);
                $bundleProduct->setName($products[$bundleProductSku][Product::NAME_ID]);
                $bundleProduct->setPrice($products[$bundleProductSku][Product::PRICE_ID]);
                $bundleProduct->setQuantity($products[$bundleProductSku][Product::QUANTITY_ID]);

                $bundleProducts[] = $bundleProduct;
                $bundlePrice += floatval($products[$bundleProductSku][Product::PRICE_ID]);
            } else {
                $isValid = false;
                break;
            }
        }

        if ($isValid) {
            $processedData->incrementValidBundlesNumber();
            $item->setProducts($bundleProducts);
            $item->setPrice($bundlePrice);
        }

        $item->setAvailable($isValid);

        $processedData->incrementBundlesNumber();

        return $item;
    }
}