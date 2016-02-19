<?php
namespace Producto\Parser;

use Monolog\Logger;
use Producto\Exceptions\FileNotFoundException;

interface ParserInterface
{
    /**
     * Parse file
     *
     * @param string $filePath
     *
     * @return array
     * @throws FileNotFoundException
     */
    public function parse($filePath);
}
