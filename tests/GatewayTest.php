<?php

namespace BlueMedia\OnlinePayments\tests;

use BlueMedia\OnlinePayments\Gateway;
use BlueMedia\OnlinePayments\Model;

/**
 * Gateway test.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments\Tests
 * @since     2015-08-08
 * @version   2.3.2
 */
class GatewayTest extends \PHPUnit_Framework_TestCase
{
    public function testDoTransactionStandard()
    {
        $transactionStandard = new Model\TransactionStandard();
        $transactionStandard->setOrderId((string) time())
            ->setAmount('123.00')
            ->setDescription('Test transaction')
            ->setGatewayId(106)
            ->setCurrency('PLN')
            ->setCustomerEmail('test@zuralski.net')
            ->setCustomerNrb('50114020040000360275384788')
            ->setTaxCountry('PL')
            ->setCustomerIp('192.168.0.34')
            ->setTitle(sprintf('Test transaction %s', $transactionStandard->getOrderId()))
            ->setReceiverName('Zuralski.net');

        $gateway = new Gateway('100006', '81532ad38b71944834059480537b324bd1ab2bd9', Gateway::MODE_SANDBOX, 'sha256');
        $html = $gateway->doTransactionStandard($transactionStandard);

        $this->assertNotEmpty($html);

        $this->assertContains('name="Amount" value="123.00"', $html);
        $this->assertContains('name="Description" value="Test transaction"', $html);
        $this->assertContains('name="GatewayID" value="106"', $html);
        $this->assertContains('name="Currency" value="PLN"', $html);
        $this->assertContains('name="CustomerEmail" value="test@zuralski.net"', $html);
        $this->assertContains('name="CustomerNRB" value="50114020040000360275384788"', $html);
        $this->assertContains('name="TaxCountry" value="PL"', $html);
        $this->assertContains('name="CustomerIP" value="192.168.0.34"', $html);
        $this->assertContains('name="Title" value="Test transaction ', $html);
        $this->assertContains('name="ReceiverName" value="Zuralski.net"', $html);
        $this->assertContains('name="Hash" value="', $html);
        $this->assertNotContains('name="Hash" value=""', $html);

        $this->assertContains('<p>Trwa przekierowanie do Bramki P&#322;atniczej Blue Media...</p>', $html);
        $this->assertContains('form action="https://pay-accept.bm.pl/payment?" method="post" id="BlueMediaPaymentForm" name="BlueMediaPaymentForm" style="display: none;"', $html);
        $this->assertContains('<noscript><p>Masz wy&#322;&#261;czon&#261; obs&#322;ug&#281; JavaScript.<br>Aby przej&#347;&#263; do Bramki P&#322;atniczej Blue Media musi w&#322;&#261;czy&#263; obs&#322;ug&#281; JavaScript w przegl&#261;darce.</p></noscript>', $html);
    }
}
