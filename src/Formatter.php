<?php

namespace BlueMedia\OnlinePayments;

/**
 * Formatter
 *
 * @author    Piotr Żuralski <piotr.zuralski@invicta.pl>
 * @copyright 2015 INVICTA
 * @package   BlueMedia\OnlinePayments
 * @since     2015-07-12 
 * @version   Release: $Id$
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
        $amount = str_replace([',', ' '], '', $amount);
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