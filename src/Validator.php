<?php

namespace BlueMedia\OnlinePayments;

use InvalidArgumentException;

/**
 * Validator.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments
 * @since     2015-08-08
 * @version   2.3.2
 */
class Validator
{
    /**
     * Validates string length.
     *
     * @param string $value
     * @param int    $maxLength
     *
     * @return bool
     */
    protected static function validateStringLength($value, $maxLength)
    {
        return !(is_string($value) && mb_strlen($value) >= 1 && mb_strlen($value) <= $maxLength);
    }

    /**
     * Validates amount.
     *
     * @param float $value
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function validateAmount($value)
    {
        if (mb_strlen(mb_substr($value, mb_strrpos($value, '.'))) > 14) {
            throw new InvalidArgumentException('Wrong Amount format, requires max 14 numbers before ".", only numbers');
        }
    }

    /**
     * Validates currency code.
     *
     * @param string $value
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function validateCurrency($value)
    {
        if (self::validateStringLength($value, 3)) {
            throw new InvalidArgumentException('Wrong Currency format, requires max 3 characters, only letters');
        }
    }

    /**
     * Validates e-mail address.
     *
     * @param string $value
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function validateEmail($value)
    {
        if (self::validateStringLength($value, 60)) {
            throw new InvalidArgumentException('Wrong CustomerEmail format, requires max 60 characters');
        }
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Wrong CustomerEmail, given value is invalid e-mail address');
        }
    }

    /**
     * Validates IP address.
     *
     * @param string $value
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function validateIP($value)
    {
        if (self::validateStringLength($value, 15)) {
            throw new InvalidArgumentException('Wrong CustomerIP format, requires max 15 characters');
        }
        if (!filter_var($value, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException('Wrong CustomerIP, not IP address');
        }
    }

    /**
     * Validates bank account number.
     *
     * @param string $value
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function validateNrb($value)
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException('Wrong CustomerNRB format, requires only numbers');
        }
        if (mb_strlen($value) !== 26) {
            throw new InvalidArgumentException('Wrong CustomerNRB format, requires exactly 26 characters');
        }
    }

    /**
     * Validates tax country name.
     *
     * @param string $value
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function validateTaxCountry($value)
    {
        if (self::validateStringLength($value, 64)) {
            throw new InvalidArgumentException('Wrong TaxCountry format, requires max 64 characters');
        }
    }

    /**
     * Validates description.
     *
     * @param string $value
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function validateDescription($value)
    {
        if (self::validateStringLength($value, 79)) {
            throw new InvalidArgumentException('Wrong description format, requires max 79 characters');
        }
    }

    /**
     * Validates gateway id.
     *
     * @param string $value
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function validateGatewayId($value)
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException('Wrong GatewayId format, requires only numbers');
        }
        if (!(mb_strlen($value) >= 1 && mb_strlen($value) <= 5)) {
            throw new InvalidArgumentException('Wrong GatewayId format, requires max 5 characters');
        }
    }

    /**
     * Validates hash.
     *
     * @param string $value
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function validateHash($value)
    {
        if (self::validateStringLength($value, 128)) {
            throw new InvalidArgumentException('Wrong hash format, requires max 128 characters');
        }
    }

    /**
     * Validates order id.
     *
     * @param string $value
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function validateOrderId($value)
    {
        if (self::validateStringLength($value, 32)) {
            throw new InvalidArgumentException('Wrong orderId format, requires max 32 characters');
        }
    }

    /**
     * Validates service id.
     *
     * @param string $value
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function validateServiceId($value)
    {
        if (!(is_numeric($value) && mb_strlen($value) >= 1 && mb_strlen($value) <= 10)) {
            throw new InvalidArgumentException('Wrong ServiceId format, requires max 10 characters');
        }
    }

    /**
     * Validates receiver name.
     *
     * @param string $value
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function validateReceiverName($value)
    {
        if (self::validateStringLength($value, 35)) {
            throw new InvalidArgumentException('Wrong receiverName format, requires max 35 characters');
        }
    }

    /**
     * Validates title.
     *
     * @param string $value
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function validateTitle($value)
    {
        if (self::validateStringLength($value, 95)) {
            throw new InvalidArgumentException('Wrong Title format, requires max 95 characters');
        }
    }
}
