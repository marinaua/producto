<?php
namespace Producto;

class DataTypes
{
    const PRODUCT = 'PRODUCT';
    const BUNDLE = 'BUNDLE';

    /** @var array */
    private static $types = array(self::PRODUCT, self::BUNDLE);

    /**
     * Check if type is available
     *
     * @param string $type
     * @return bool
     */
    public static function isAvailableType($type)
    {
        return in_array($type, self::$types);
    }
}
