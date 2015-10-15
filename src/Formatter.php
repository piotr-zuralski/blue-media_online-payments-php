<?php

namespace BlueMedia\OnlinePayments;

/**
 * Formatter
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments
 * @since     2015-08-08
 * @version   2.3.1
 */
class Formatter
{
    /**
     * Format amount
     *
     * @param float|number $amount
     *
     * @return string
     */
    public static function formatAmount($amount)
    {
        $amount = str_replace(array(',', ' '), '', $amount);
        return number_format((float)$amount, 2, '.', '');
    }

    public static function formatDescription($value)
    {
        if (extension_loaded('iconv')) {
            return iconv('UTF-8', 'ASCII//translit', $value);
        }
        return $value;
    }
}
