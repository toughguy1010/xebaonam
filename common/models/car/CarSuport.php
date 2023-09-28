<?php

/**
 * This is the model class for table "car".
 *
 * The followings are the available columns in table 'car':
 */
class CarSuport
{
    const CAR_HOT = 1;

    public static function optionYears()
    {
        return [
            1 => '1 năm',
            2 => '2 năm',
            3 => '3 năm',
            4 => '4 năm',
            5 => '5 năm',
            6 => '6 năm',
            7 => '7 năm',
        ];
    }

    public static function optionPrepay()
    {
        return [1 => 0.1, 2 => 0.2, 3 => 0.3, 4 => 0.4, 5 => 0.5, 6 => 0.6, 7 => 0.7];
    }

    public static function optionTypes()
    {
        return [1 => 'Sản phẩm truyền thống', 2 => 'Sản phẩm 50/50'];
    }

    public static function optionInterests()
    {
        return [1 => 6.99, 2 => 7.99];
    }

    public static function optionEarnMin()
    {
        return [1 => 0.1, 2 => 0.5];
    }

    public static function optionPaymentMethods()
    {
        return [1 => 'Theo tháng'];
    }

}
