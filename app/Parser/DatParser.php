<?php
namespace Producto\Parser;

use Monolog\Logger;
use Producto\DataTypes;
use Producto\Exceptions\FileNotFoundException;

class DatParser extends AbstractParser
{
    const SKU_ID = 0;
    const TYPE_ID = 1;
    const DATA_ID = 2;

    const REQUIRED_LINE_PARTS_COUNT = 3;
    const REQUIRED_PRODUCT_DATA_COUNT = 3;
    const MIN_REQUIRED_BUNDLE_DATA_COUNT = 2;

    /** @var  Logger */
    private $logger;

    public function __construct($logger)
    {
        $this->logger = $logger;
    }

    /**
     * Parse file
     *
     * @param $filePath
     *
     * @return array
     * @throws FileNotFoundException
     */
    public function parse($filePath)
    {
        $parsed = [];

        $handle = fopen($filePath, "r");

        if (false === $handle) {
            throw new FileNotFoundException();
        }

        while (false !== ($line = fgets($handle))) {
            $lineData = explode('|', str_replace(["\r\n", "\n", "\r"], "", $line));

            if (false === $this->isLineFormatValid($lineData)) {
                $this->logger->addInfo("Bad data: " . $line);
                continue;
            }

            $parsed['itemsList'][] = $lineData[self::SKU_ID];

            $key = $lineData[self::TYPE_ID] == DataTypes::PRODUCT ? 'products' : 'bundles';

            $parsed[$key][$lineData[self::SKU_ID]] = explode(',', $lineData[self::DATA_ID]);
        }

        fclose($handle);

        return $parsed;
    }

    /**
     * Check line format
     *
     * @param $lineData
     *
     * @return bool
     */
    private function isLineFormatValid($lineData)
    {
        if (count($lineData) != self::REQUIRED_LINE_PARTS_COUNT
            || false === DataTypes::isAvailableType($lineData[self::TYPE_ID])) {
            return false;
        }

        $lineData[self::DATA_ID] = explode(',', $lineData[self::DATA_ID]);

        foreach ($lineData[self::DATA_ID] as $data) {
            if ($data === '') {
                return false;
            }
        }

        switch ($lineData[self::TYPE_ID]) {
            case DataTypes::PRODUCT:
                if (count($lineData[self::DATA_ID]) != self::REQUIRED_PRODUCT_DATA_COUNT) {
                    return false;
                }

                break;
            case DataTypes::BUNDLE:
                if (count($lineData[self::DATA_ID]) < self::MIN_REQUIRED_BUNDLE_DATA_COUNT) {
                    return false;
                }

                break;
        }

        return true;
    }
}