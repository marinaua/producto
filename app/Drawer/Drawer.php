<?php
namespace Producto\Drawer;

use Producto\Entity\EntityInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Drawer
{
    /** @var  DrawingStrategyInterface */
    private $drawingStrategy;

    public function __construct(DrawingStrategyInterface $drawingStrategy)
    {
        $this->drawingStrategy = $drawingStrategy;
    }

    /**
     * Build table and draw it into output
     *
     * @param EntityInterface|string $item
     * @param OutputInterface $output
     */
    public function draw($item, OutputInterface $output)
    {
        $table = $this->drawingStrategy->build($item);

        foreach ($table as $tableLine) {
            $output->writeln($tableLine);
        }
    }
}
