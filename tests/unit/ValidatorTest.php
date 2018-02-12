<?php

namespace BlueMedia\OnlinePayments\Tests\Unit;

use BlueMedia\OnlinePayments\Validator;

/**
 * Validator test.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments\Tests
 * @since     2015-08-08
 * @version   2.3.3
 */
class ValidatorTest extends \Codeception\Test\Unit
{
    public function testValidInputValidateAmount()
    {
        $this->tester->assertNull(Validator::validateAmount(123.00));
        $this->tester->assertNull(Validator::validateAmount(123));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Wrong Amount format, requires max 14 numbers before ".", only numbers
     * @expectedExceptionCode 0
     */
    public function testInvalidInputValidateAmount()
    {
        Validator::validateAmount(123456789012345.00);
        Validator::validateAmount(12);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Wrong Amount format, only one "." is possible
     * @expectedExceptionCode 0
     */
    public function testInvalidDoublePunctuationsInputValidateAmount()
    {
        $this->tester->assertNull(Validator::validateAmount('12345.6789012345.00'));
    }

    public function testValidInputValidateCurrency()
    {
        $this->tester->assertNull(Validator::validateCurrency('PLN'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Wrong Currency format, requires max 3 characters, only letters
     * @expectedExceptionCode 0
     */
    public function testInvalidInputValidateCurrency()
    {
        Validator::validateCurrency('PLNA');
    }

    public function testValidInputValidateEmail()
    {
        $this->tester->assertNull(Validator::validateEmail('example@example.com'));
    }

    public function testValidLongInputValidateEmail()
    {
        $this->tester->assertNull(Validator::validateEmail(sprintf('%s@wp.pl', str_repeat('A', 54))));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Wrong CustomerEmail format, requires max 60 characters
     * @expectedExceptionCode 0
     */
    public function testInvalidTooLongInputValidateEmail()
    {
        Validator::validateEmail(sprintf('%s@example.com', str_repeat('AA', 30)));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Wrong CustomerEmail, given value is invalid e-mail address
     * @expectedExceptionCode 0
     */
    public function testInvalidInputValidateEmail()
    {
        Validator::validateEmail(sprintf('%s@example', str_repeat('A', 15)));
    }

    public function testValidInputValidateIP()
    {
        $this->tester->assertNull(Validator::validateIP('255.255.255.255'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Wrong CustomerIP format, requires max 15 characters
     * @expectedExceptionCode 0
     */
    public function testInvalidInputValidateIP()
    {
        Validator::validateIP('255.255.255.255.255');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Wrong CustomerIP, not IP address
     * @expectedExceptionCode 0
     */
    public function testInvalidIPInputValidateIP()
    {
        Validator::validateIP('a.b.255.255.255');
    }

    public function testValidInputValidateNrb()
    {
        $this->tester->assertNull(Validator::validateNrb('50114020040000360275384788'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Wrong CustomerNRB format, requires exactly 26 characters
     * @expectedExceptionCode 0
     */
    public function testInvalidInputValidateNrb()
    {
        Validator::validateNrb('501140200400003602753847889');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Wrong CustomerNRB format, requires only numbers
     * @expectedExceptionCode 0
     */
    public function testInvalidNrbInputValidateNrb()
    {
        Validator::validateNrb('5011402004bv003602753847889');
    }

    public function testValidInputValidateTaxCountry()
    {
        $this->tester->assertNull(Validator::validateTaxCountry(
            'Wielka Arabska Libijska Dżamahirijja Ludowo-Socjalistyczna'
        ));
        $this->tester->assertNull(Validator::validateTaxCountry(str_repeat('A', 64)));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Wrong TaxCountry format, requires max 64 characters
     * @expectedExceptionCode 0
     */
    public function testInvalidInputValidateTaxCountry()
    {
        Validator::validateTaxCountry(str_repeat('A', 65));
    }

    public function testValidInputValidateDescription()
    {
        $this->tester->assertNull(Validator::validateDescription('Płatność za zamówienie nr 1437503008271'));
        $this->tester->assertNull(Validator::validateDescription(str_repeat('A', 79)));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Wrong description format, requires max 79 characters
     * @expectedExceptionCode 0
     */
    public function testInvalidInputValidateDescription()
    {
        Validator::validateDescription(str_repeat('A', 80));
    }

    public function testValidInputValidateGatewayId()
    {
        $this->tester->assertNull(Validator::validateGatewayId(2));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Wrong GatewayId format, requires only numbers
     * @expectedExceptionCode 0
     */
    public function testValidInputValidateGatewayIdString()
    {
        $this->tester->assertNull(Validator::validateGatewayId('a12345'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Wrong GatewayId format, requires max 5 characters
     * @expectedExceptionCode 0
     */
    public function testInvalidInputValidateGatewayId()
    {
        $this->tester->assertNull(Validator::validateGatewayId(123456));
    }

    public function testValidInputValidateHash()
    {
        $this->tester->assertNull(Validator::validateHash(hash('sha256', 'abcd')));
        $this->tester->assertNull(Validator::validateHash(hash('sha512', 'abcd')));
        $this->tester->assertNull(Validator::validateHash(str_repeat('A', 128)));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Wrong hash format, requires max 128 characters
     * @expectedExceptionCode 0
     */
    public function testInvalidInputValidateHash()
    {
        Validator::validateHash(str_repeat('A', 129));
    }

    public function testValidInputValidateOrderId()
    {
        $this->tester->assertNull(Validator::validateOrderId('1437503008271'));
        $this->tester->assertNull(Validator::validateOrderId(str_repeat('A', 32)));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Wrong orderId format, requires max 32 characters
     * @expectedExceptionCode 0
     */
    public function testInvalidInputValidateOrderId()
    {
        Validator::validateOrderId(str_repeat('A', 33));
    }

    public function testValidInputValidateServiceId()
    {
        $this->tester->assertNull(Validator::validateServiceId(1234567890));
        $this->tester->assertNull(Validator::validateServiceId(str_repeat(1, 10)));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Wrong ServiceId format, requires max 10 characters
     * @expectedExceptionCode 0
     */
    public function testInvalidInputValidateServiceId()
    {
        Validator::validateServiceId(str_repeat(2, 11));
    }

    public function testValidInputValidateReceiverName()
    {
        $this->tester->assertNull(Validator::validateReceiverName('John Doe'));
        $this->tester->assertNull(Validator::validateReceiverName(str_repeat('A', 35)));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Wrong receiverName format, requires max 35 characters
     * @expectedExceptionCode 0
     */
    public function testInvalidInputValidateReceiverName()
    {
        Validator::validateReceiverName(str_repeat('A', 36));
    }

    public function testValidInputValidateTitle()
    {
        $this->tester->assertNull(Validator::validateTitle('My Little John Doe Title'));
        $this->tester->assertNull(Validator::validateTitle(str_repeat('A', 95)));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Wrong Title format, requires max 95 characters
     * @expectedExceptionCode 0
     */
    public function testInvalidInputValidateTitle()
    {
        Validator::validateTitle(str_repeat('A', 96));
    }
}
