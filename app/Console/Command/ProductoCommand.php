<?php
namespace Producto\Console\Command;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Producto\Drawer\BundleDrawingStrategy;
use Producto\Drawer\Drawer;
use Producto\Drawer\ErrorDrawingStrategy;
use Producto\Drawer\ProductDrawingStrategy;
use Producto\Entity\Product;
use Producto\Exceptions\InvalidItemException;
use Producto\Parser\DatParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Producto\DataProcessor;
use Producto\ProcessedData;
use Symfony\Component\Console\Question\Question;

class ProductoCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('producto:run')
            ->setDescription('Show info about products')
            ->addArgument(
                "path",
                InputArgument::REQUIRED,
                "What is the path to file?"
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $applicationId = substr(md5((new \DateTime())->getTimestamp()), -5);

        $logger = new Logger("Producto");
        $logger->pushHandler(new StreamHandler($this->getLoggerPath()), Logger::INFO);
        $logger->addInfo('Application started. Application ID: ' . $applicationId);

        // Parse data
        $parser = new DatParser($logger);
        $data = $parser->parse($input->getArgument("path"));

        // Process data
        $dataProcessor = new DataProcessor();
        $processedData = $dataProcessor->process($data);

        $this->showGeneralInfo($processedData, $output);

        $this->showExitHint($output);

        $helper = $this->getHelper('question');
        $question = new Question("Enter product number: ");

        while(true) {
            $userInput = $helper->ask($input, $output, $question);

            if ($userInput === ':q') {
                $output->writeln("Good bye!");
                $logger->addInfo("Application stopped. Application ID: " . $applicationId);
                break;
            }

            $this->showData($processedData, $userInput, $output);

            $output->writeln(PHP_EOL);
        }
    }

    /**
     * Show general information
     *
     * @param ProcessedData $processedData
     * @param OutputInterface $output
     */
    private function showGeneralInfo(ProcessedData $processedData, OutputInterface $output)
    {
        $output->writeln(
            "Total number of read items: " . $processedData->getItemsNumber()
        );
        $output->writeln(
            "Total number of sellable items: " . $processedData->getAvailableItemsNumber()
        );
        $output->writeln(
            "Number of items of type 'PRODUCT': " . $processedData->getProductsNumber()
        );
        $output->writeln(
            "Number of non-sellable items of type 'PRODUCT' (quantity is 0): "
            . $processedData->getUnavailableProductsNumber()
        );
        $output->writeln(
            "Number of items of type 'BUNDLE': " . $processedData->getBundlesNumber()
        );
        $output->writeln(
            "Number of invalid items of type 'BUNDLE': "
            . $processedData->getInvalidBundlesNumber()
        );
    }

    /**
     * Show exit hint
     *
     * @param OutputInterface $output
     */
    private function showExitHint(OutputInterface $output)
    {
        $output->writeln(PHP_EOL . "HINT: If you want to quit type ':q'" . PHP_EOL);
    }

    /**
     * Show item data
     *
     * @param ProcessedData $processedData
     * @param $userInput
     * @param OutputInterface $output
     */
    private function showData(ProcessedData $processedData, $userInput, OutputInterface $output)
    {
        try {
            $item = $processedData->getItemByLineNumber($userInput);

            if ($item instanceof Product) {
                $drawer = new Drawer(new ProductDrawingStrategy());
            } else {
                $drawer = new Drawer(new BundleDrawingStrategy());
            }
        } catch(\Exception $e) {
            $drawer = new Drawer(new ErrorDrawingStrategy());

            $item = $e->getMessage();
        }

        $drawer->draw($item, $output);
    }

    /**
     * Get path to log file
     *
     * @return string
     */
    private function getLoggerPath()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..'
            . DIRECTORY_SEPARATOR . '..'
            . DIRECTORY_SEPARATOR . '..'
            . DIRECTORY_SEPARATOR . 'var'
            . DIRECTORY_SEPARATOR . 'logs'
            . DIRECTORY_SEPARATOR . 'log.txt';
    }
}