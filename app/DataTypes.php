<?php
namespace Producto;


class DataTypes
{
    const PRODUCT = 'PRODUCT';
    const BUNDLE = 'BUNDLE';

    private static $types = array(self::PRODUCT, self::BUNDLE);

    /**
     * @param $type
     * @return bool
     */
    public static function isAvailableType($type)
    {
        return in_array($type, self::$types);
    }
}