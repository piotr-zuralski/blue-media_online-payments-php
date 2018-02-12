<?php

namespace BlueMedia\OnlinePayments\Tests\Unit;

use BlueMedia\OnlinePayments\Formatter;
use BlueMedia\OnlinePayments\Util\EnvironmentRequirements;
use Codeception\Util\Stub;

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

    // tests
    public function testValidInputFormatAmountInteger()
    {
        $this->tester->assertSame('1234567890.00', Formatter::formatAmount(1234567890));
    }

    public function testValidInputFormatAmountFloat()
    {
        $this->tester->assertSame('1234567890.00', Formatter::formatAmount(1234567890.00));
        $this->tester->assertSame('1234567890.00', Formatter::formatAmount('1234567890.00'));
        $this->tester->assertSame('123.46', Formatter::formatAmount('123.4567890.00'));
    }

    public function testValidInputFormatAmountStringWithComma()
    {
        $this->tester->assertSame('12345678.00', Formatter::formatAmount(12345678, 90));
        $this->tester->assertSame('1234567890.00', Formatter::formatAmount('12345678,90'));
        $this->tester->assertSame('1234567890.00', Formatter::formatAmount('1234,5678,90'));
    }

    public function testValidInputFormatAmountString()
    {
        $this->tester->assertSame('1234567890.00', Formatter::formatAmount('1234 567890'));
        $this->tester->assertSame('1234567890.00', Formatter::formatAmount('1234 567 890'));
    }

    public function testValidInputFormatDescription()
    {
        if (ICONV_IMPL === 'unknown') {
            $this->markTestSkipped(sprintf('There\'s wrong iconv lib installed (ICONV_IMPL: "%s")', ICONV_IMPL));
        }

        Stub::make(EnvironmentRequirements::class, array(
            'hasPhpExtension' => true,
        ));
        $this->tester->assertSame('EOASLZZCN eoaslzzcn', Formatter::formatDescription('ĘÓĄŚŁŻŹĆŃ ęóąśłżźćń'));
    }

    public function testValidInputFormatDescriptionWithoutUTF8()
    {
        Stub::make(EnvironmentRequirements::class, array(
            'hasPhpExtension' => false,
        ));
        $this->tester->assertSame('abc', Formatter::formatDescription('abc'));
    }
}
