<?php
namespace Producto\Drawer;


abstract class AbstractDrawingStrategy implements DrawingStrategyInterface
{
    const V_LINE = '|';
    const CORNER = '+';
    const H_LINE = '-';
    const SPACE = " ";

    const SKU_LEN = 12;
    const NAME_LEN = 22;
    const PRICE_LEN = 8;

    const SKU = "SKU";
    const NAME = "Name";
    const PRICE = "Price";

    abstract protected function buildBody($item);

    public function build($item)
    {
        return array_merge(
            $this->buildHeader(), $this->buildBody($item), $this->buildFooter()
        );
    }

    protected function buildHeader()
    {
        $header[] = $this->getLine();
        $header[] = $this->getTitles();
        $header[] = $this->getLine();

        return $header;
    }

    protected function buildFooter()
    {
        return [$this->getLine()];
    }

    protected function getLine()
    {
        return str_repeat(self::H_LINE, self::SKU_LEN)
            . self::CORNER
            . str_repeat(self::H_LINE, self::NAME_LEN)
            . self::CORNER
            . str_repeat(self::H_LINE, self::PRICE_LEN);
    }

    protected function getTitles()
    {
        return str_repeat(self::SPACE, self::SKU_LEN - strlen(self::SKU) - 1)
            . self::SKU . self::SPACE . self::V_LINE
            . str_repeat(self::SPACE, self::NAME_LEN - strlen(self::NAME) - 1)
            . self::NAME . self::SPACE . self::V_LINE
            . str_repeat(self::SPACE, self::PRICE_LEN - strlen(self::PRICE) - 1)
            . self::PRICE;

    }
}