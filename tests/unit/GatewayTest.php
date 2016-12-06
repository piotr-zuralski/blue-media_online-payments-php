<?php

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
class GatewayTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var int
     */
    private $serviceId = 123456;

    /**
     * @var string
     */
    private $hashingSalt = '81532ad38b71944834059480537b324bd1ab2bd9';

    /**
     * @var string
     */
    private $hashingSeparator = '|';

    /**
     * @var Gateway
     */
    private $gateway = null;

    protected function setUp()
    {
        $this->gateway = new Gateway(
            $this->serviceId,
            $this->hashingSalt,
            Gateway::MODE_SANDBOX,
            'sha256',
            $this->hashingSeparator
        );
    }

    protected function tearDown()
    {
    }

    // tests
    /**
     * @group Transaction
     * @group TransactionStandard
     */
    public function testDoTransactionStandard()
    {
        $transaction = new Model\TransactionStandard();
        $transaction->setOrderId((string) time())
            ->setAmount('123.45')
            ->setDescription('Test transaction')
            ->setGatewayId(106)
            ->setCurrency('PLN')
            ->setCustomerEmail('test@zuralski.net')
            ->setCustomerNrb('50114020040000360275384788')
            ->setTaxCountry('PL')
            ->setCustomerIp('192.168.0.34')
            ->setTitle(sprintf('Test transaction %s', $transaction->getOrderId()))
            ->setReceiverName('Zuralski.net');

        $html = $this->gateway->doTransactionStandard($transaction);

        $this->assertNotEmpty($html);

        $this->assertContains(sprintf('name="Amount" value="%s"', $transaction->getAmount()), $html);
        $this->assertContains(sprintf('name="Description" value="%s"', $transaction->getDescription()), $html);
        $this->assertContains(sprintf('name="GatewayID" value="%s"', $transaction->getGatewayId()), $html);
        $this->assertContains(sprintf('name="Currency" value="%s"', $transaction->getCurrency()), $html);
        $this->assertContains(sprintf('name="CustomerEmail" value="%s"', $transaction->getCustomerEmail()), $html);
        $this->assertContains(sprintf('name="CustomerNRB" value="%s"', $transaction->getCustomerNrb()), $html);
        $this->assertContains(sprintf('name="TaxCountry" value="%s"', $transaction->getTaxCountry()), $html);
        $this->assertContains(sprintf('name="CustomerIP" value="%s"', $transaction->getCustomerIp()), $html);
        $this->assertContains(sprintf('name="Title" value="%s"', $transaction->getTitle()), $html);
        $this->assertContains(sprintf('name="ReceiverName" value="%s"', $transaction->getReceiverName()), $html);
        $this->assertContains(sprintf('name="Hash" value="%s"', $transaction->getHash()), $html);
        $this->assertNotContains('name="Hash" value=""', $html);

        $this->assertContains('<p>Trwa przekierowanie do Bramki P&#322;atniczej Blue Media...</p>', $html);
        $this->assertContains('<form action="https://pay-accept.bm.pl/payment" method="post" id="BlueMediaPaymentForm" name="BlueMediaPaymentForm">', $html);
        $this->assertContains('<noscript><p>Masz wy&#322;&#261;czon&#261; obs&#322;ug&#281; JavaScript.<br>Aby przej&#347;&#263; do Bramki P&#322;atniczej Blue Media musi w&#322;&#261;czy&#263; obs&#322;ug&#281; JavaScript w przegl&#261;darce.</p></noscript>', $html);
    }

    /**
     * @group Itn
     */
    public function testDoItnInWithoutParameters()
    {
        $this->assertNull($this->gateway->doItnIn());
    }
}