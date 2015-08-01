<?php

namespace BlueMedia\OnlinePayments\Tests;
use BlueMedia\OnlinePayments\Formatter;


/**
 * (description) 
 *
 * @author    Piotr Żuralski <piotr.zuralski@invicta.pl>
 * @copyright 2015 INVICTA
 * @package   BlueMedia\OnlinePayments\Tests
 * @since     2015-07-21 
 * @version   Release: $Id$
 */
class FormatterTest extends \PHPUnit_Framework_TestCase
{

    public function testValidInputFormatAmount()
    {
        $this->assertEquals('1234567890.00', Formatter::formatAmount(1234567890));
        $this->assertEquals('1234567890.00', Formatter::formatAmount('12345678,90'));
        $this->assertEquals('1234567890.00', Formatter::formatAmount('1234 567890'));
    }

    public function testValidInputFormatDescription()
    {
        $this->assertEquals('EOASLZZCN eoaslzzcn', Formatter::formatDescription('ĘÓĄŚŁŻŹĆŃ ęóąśłżźćń'));
    }

}
 