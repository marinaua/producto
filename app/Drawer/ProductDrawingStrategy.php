<?php
namespace Producto\Drawer;

use Producto\Entity\Product;

class ProductDrawingStrategy extends AbstractDrawingStrategy
{
    /**
     * Build table body
     *
     * @param Product $item
     *
     * @return array
     */
    protected function buildBody($item)
    {
        $body[] = str_repeat(self::SPACE, self::SKU_LEN - strlen($item->getSku()) - 1)
            . $item->getSku() . self::SPACE . self::V_LINE
            . str_repeat(self::SPACE, self::NAME_LEN - strlen($item->getName()) - 1)
            . $item->getName() . self::SPACE . self::V_LINE
            . str_repeat(self::SPACE, self::PRICE_LEN - strlen($item->getPrice()) - 1)
            . $item->getPrice();

        return $body;
    }
}
