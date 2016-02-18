<?php
namespace Producto\Parser;

use Monolog\Logger;

interface ParserInterface
{
    public function parse($filePath);
}