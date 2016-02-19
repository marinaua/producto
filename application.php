<?php

require 'vendor/autoload.php';

use Producto\Console\Command\ProductoCommand;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new ProductoCommand());

$application->run();
