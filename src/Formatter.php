<?php

namespace BlueMedia\OnlinePayments;

use BlueMedia\OnlinePayments\Util\EnvironmentRequirements;

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

        if (EnvironmentRequirements::hasPhpExtension('iconv')) {
            $return = iconv('UTF-8', 'ASCII//TRANSLIT', $value);

            return $return;
        }

        if (EnvironmentRequirements::hasPhpExtension('mbstring')) {
            $tmp = ini_get('mbstring.substitute_character');
            @ini_set('mbstring.substitute_character', 'none');

            $return = mb_convert_encoding($value, 'ASCII', 'UTF-8');
            @ini_set('mbstring.substitute_character', $tmp);

            return $return;
        }

        return $value;
    }
}
