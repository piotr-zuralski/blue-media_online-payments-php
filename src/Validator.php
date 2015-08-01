<?php

namespace BlueMedia\OnlinePayments;

use InvalidArgumentException;

/**
 * (description) 
 *
 * @author    Piotr Żuralski <piotr.zuralski@invicta.pl>
 * @copyright 2015 INVICTA
 * @package   BlueMedia\OnlinePayments
 * @since     2015-07-12 
 * @version   Release: $Id$
 */
class Validator 
{

    /**
     * (description)
     *
     * @param $value
     * @param $maxLength
     *
     * @return bool
     */
    protected static function validateStringLength($value, $maxLength)
    {
        return !(is_string($value) && mb_strlen($value) >= 1 && mb_strlen($value) <= $maxLength);
    }

    public static function validateAmount($amount)
    {
        if (mb_strlen(mb_substr($amount, mb_strrpos($amount, '.'))) > 14) {
            throw new InvalidArgumentException('Wrong Amount format, requires max 14 numbers before ".", only numbers');
        }
    }

    /**
     * (description)
     *
     * @param $value
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    public static function validateCurrency($value)
    {
        if (self::validateStringLength($value, 3)) {
            throw new InvalidArgumentException('Wrong Currency format, requires max 3 characters, only letters');
        }
    }

    public static function validateEmail($value)
    {
        if (self::validateStringLength($value, 60)) {
            throw new InvalidArgumentException('Wrong CustomerEmail format, requires max 60 characters');
        }
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Wrong CustomerEmail, given value is invalid e-mail address');
        }
    }

    public static function validateIP($value)
    {
        if (self::validateStringLength($value, 15)) {
            throw new InvalidArgumentException('Wrong CustomerIP format, requires max 15 characters');
        }
        if (!filter_var($value, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException('Wrong CustomerIP, not IP address');
        }
    }

    public static function validateNrb($value)
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException('Wrong CustomerNRB format, requires only numbers');
        }
        if (mb_strlen($value) != 26) {
            throw new InvalidArgumentException('Wrong CustomerNRB format, requires exactly 26 characters');
        }
    }

    public static function validateTaxCountry($value)
    {
        if (self::validateStringLength($value, 64)) {
            throw new InvalidArgumentException('Wrong TaxCountry format, requires max 64 characters');
        }
    }

    public static function validateDescription($value)
    {
        if (self::validateStringLength($value, 79)) {
            throw new InvalidArgumentException('Wrong description format, requires max 79 characters');
        }
    }

    public static function validateGatewayId($value)
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException('Wrong GatewayId format, requires only numbers');
        }
        if (!(mb_strlen($value) >= 1 && mb_strlen($value) <= 5)) {
            throw new InvalidArgumentException('Wrong GatewayId format, requires max 5 characters');
        }
    }

    public static function validateHash($value)
    {
        if (self::validateStringLength($value, 128)) {
            throw new InvalidArgumentException('Wrong hash format, requires max 128 characters');
        }
    }

    public static function validateOrderId($value)
    {
        if (self::validateStringLength($value, 32)) {
            throw new InvalidArgumentException('Wrong orderId format, requires max 32 characters');
        }
    }

    public static function validateServiceId($value)
    {
        if (!(is_numeric($value) && mb_strlen($value) >= 1 && mb_strlen($value) <= 10)) {
            throw new InvalidArgumentException('Wrong ServiceId format, requires max 10 characters');
        }
    }

    public static function validateReceiverName($value)
    {
        if (self::validateStringLength($value, 35)) {
            throw new InvalidArgumentException('Wrong receiverName format, requires max 35 characters');
        }
    }

    public static function validateTitle($value)
    {
        if (self::validateStringLength($value, 95)) {
            throw new InvalidArgumentException('Wrong Title format, requires max 95 characters');
        }
    }
}