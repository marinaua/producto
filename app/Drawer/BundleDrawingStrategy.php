<?php
namespace Producto\Drawer;


class BundleDrawingStrategy extends AbstractDrawingStrategy
{

    protected function buildBody($item)
    {
        $body[] = str_repeat(self::SPACE, self::SKU_LEN - strlen($item->getSku()) - 1)
            . $item->getSku() . self::SPACE . self::V_LINE
            . str_repeat(self::SPACE, self::NAME_LEN) . self::V_LINE;

        foreach ($item->getProducts() as $product) {
            $body[] = str_repeat(self::SPACE, self::SKU_LEN) . self::V_LINE
                . str_repeat(self::SPACE, self::NAME_LEN - strlen($product->getName()) - 1)
                . $product->getName() . self::SPACE . self::V_LINE;
        }


        $body[] = str_repeat(self::SPACE, self::SKU_LEN) . self::V_LINE
            . str_repeat(self::SPACE, self::NAME_LEN) . self::V_LINE
            . str_repeat(self::SPACE, self::PRICE_LEN - strlen($item->getPrice()) - 1)
            . $item->getPrice();

        return $body;
    }
}