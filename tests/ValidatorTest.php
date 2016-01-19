<?php

namespace BlueMedia\OnlinePayments\tests;

use BlueMedia\OnlinePayments\Validator;
use InvalidArgumentException;

/**
 * Validator test.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments\Tests
 * @since     2015-08-08
 * @version   2.3.2
 */
class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testValidInputValidateAmount()
    {
        $this->assertNull(Validator::validateAmount(123.00));
        $this->assertNull(Validator::validateAmount(123));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidInputValidateAmount()
    {
        Validator::validateAmount(123456789012345.00);
    }

    public function testValidInputValidateCurrency()
    {
        $this->assertNull(Validator::validateCurrency('PLN'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidInputValidateCurrency()
    {
        Validator::validateCurrency('PLNA');
    }

    public function testValidInputValidateEmail()
    {
        $this->assertNull(Validator::validateEmail('example@example.com'));
        $this->assertNull(Validator::validateEmail(sprintf('%s@wp.pl', str_repeat('A', 54))));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidInputValidateEmail()
    {
        Validator::validateEmail(sprintf('%s@example.com', str_repeat('AA', 30)));
    }

    public function testValidInputValidateIP()
    {
        $this->assertNull(Validator::validateIP('255.255.255.255'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidInputValidateIP()
    {
        Validator::validateIP('255.255.255.255.255');
    }

    public function testValidInputValidateNrb()
    {
        $this->assertNull(Validator::validateNrb('50114020040000360275384788'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidInputValidateNrb()
    {
        Validator::validateNrb('501140200400003602753847889');
    }

    public function testValidInputValidateTaxCountry()
    {
        $this->assertNull(Validator::validateTaxCountry('Wielka Arabska Libijska Dżamahirijja Ludowo-Socjalistyczna'));
        $this->assertNull(Validator::validateTaxCountry(str_repeat('A', 64)));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidInputValidateTaxCountry()
    {
        Validator::validateTaxCountry(str_repeat('A', 65));
    }

    public function testValidInputValidateDescription()
    {
        $this->assertNull(Validator::validateDescription('Płatność za zamówienie nr 1437503008271'));
        $this->assertNull(Validator::validateDescription(str_repeat('A', 79)));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidInputValidateDescription()
    {
        Validator::validateDescription(str_repeat('A', 80));
    }

    public function testValidInputValidateGatewayId()
    {
        $this->assertNull(Validator::validateGatewayId(2));
        $this->assertNull(Validator::validateGatewayId('234'));
        $this->assertNull(Validator::validateGatewayId('12345'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidInputValidateGatewayId()
    {
        Validator::validateGatewayId(123456);
    }

    public function testValidInputValidateHash()
    {
        $this->assertNull(Validator::validateHash(hash('sha256', 'abcd')));
        $this->assertNull(Validator::validateHash(hash('sha512', 'abcd')));
        $this->assertNull(Validator::validateHash(str_repeat('A', 128)));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidInputValidateHash()
    {
        Validator::validateHash(str_repeat('A', 129));
    }

    public function testValidInputValidateOrderId()
    {
        $this->assertNull(Validator::validateOrderId('1437503008271'));
        $this->assertNull(Validator::validateOrderId(str_repeat('A', 32)));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidInputValidateOrderId()
    {
        Validator::validateOrderId(str_repeat('A', 33));
    }

    public function testValidInputValidateServiceId()
    {
        $this->assertNull(Validator::validateServiceId(1234567890));
        $this->assertNull(Validator::validateServiceId(str_repeat(1, 10)));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidInputValidateServiceId()
    {
        Validator::validateServiceId(str_repeat(2, 11));
    }

    public function testValidInputValidateReceiverName()
    {
        $this->assertNull(Validator::validateReceiverName('John Doe'));
        $this->assertNull(Validator::validateReceiverName(str_repeat('A', 35)));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidInputValidateReceiverName()
    {
        Validator::validateReceiverName(str_repeat('A', 36));
    }

    public function testValidInputValidateTitle()
    {
        $this->assertNull(Validator::validateTitle('My Little John Doe Title'));
        $this->assertNull(Validator::validateTitle(str_repeat('A', 95)));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidInputValidateTitle()
    {
        Validator::validateTitle(str_repeat('A', 96));
    }

//    public function testValidateTitle($value)
//    {
//        if (self::testValidateStringLength($value, 95)) {
//            throw new InvalidArgumentException('Wrong Title format, requires max 95 characters');
//        }
//    }
}
