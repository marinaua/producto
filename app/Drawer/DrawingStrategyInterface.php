<?php
namespace Producto\Drawer;


use Producto\Entity\EntityInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface DrawingStrategyInterface
{
    public function build($item);
}