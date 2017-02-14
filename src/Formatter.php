<?php

namespace BlueMedia\OnlinePayments;

/**
 * Formatter class.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments
 * @since     2015-08-08
 * @version   2.3.3
 */
class Formatter
{
    /**
     * Format amount.
     *
     * @param float|number $amount
     *
     * @return string
     */
    public static function formatAmount($amount)
    {
        $amount = str_replace(array(',', ' '), '', $amount);
        $amount = number_format((float) $amount, 2, '.', '');

        return $amount;
    }

    /**
     * Format description.
     *
     * @param string $value
     *
     * @return string
     */
    public static function formatDescription($value)
    {
        $value = trim($value);
        if (extension_loaded('iconv')) {
            return iconv('UTF-8', 'ASCII//translit', $value);
        }

        return $value;
    }
}
