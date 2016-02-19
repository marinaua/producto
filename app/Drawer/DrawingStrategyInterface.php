<?php
namespace Producto\Drawer;

interface DrawingStrategyInterface
{
    /**
     * Build table
     *
     * @param @param EntityInterface|string $item
     *
     * @return array
     */
    public function build($item);
}
