<?php
namespace Producto\Drawer;

class ErrorDrawingStrategy extends AbstractDrawingStrategy
{
    /**
     * Build table body
     *
     * @param string $item
     *
     * @return array
     */
    protected function buildBody($item)
    {
        $tableLen = self::SKU_LEN + self::NAME_LEN + self::PRICE_LEN + 2;

        $errorLength = strlen($item);

        $rightSpaces = ($tableLen - $errorLength) / 2;

        $body[] = str_repeat(self::SPACE, $rightSpaces) . $item;

        return $body;
    }
}
