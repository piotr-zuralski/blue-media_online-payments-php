<?php

use BlueMedia\OnlinePayments\Formatter;

/**
 * Formatter test.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments\Tests
 * @since     2015-08-08
 * @version   2.3.3
 */
class FormatterTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testValidInputFormatAmount()
    {
        $this->assertSame('1234567890.00', Formatter::formatAmount(1234567890));
        $this->assertSame('1234567890.00', Formatter::formatAmount('12345678,90'));
        $this->assertSame('1234567890.00', Formatter::formatAmount('1234 567890'));
    }

    public function testValidInputFormatDescription()
    {
        $this->assertSame('EOASLZZCN eoaslzzcn', Formatter::formatDescription('ĘÓĄŚŁŻŹĆŃ ęóąśłżźćń'));
    }
}
