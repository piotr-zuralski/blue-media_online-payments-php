<?php

namespace BlueMedia\OnlinePayments\Tests;

use BlueMedia\OnlinePayments\Gateway;
use BlueMedia\OnlinePayments\Model;

/**
 * (description) 
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments\Tests
 * @since     2015-08-08
 * @version   2.3.1
 */
class GatewayTest extends \PHPUnit_Framework_TestCase
{

    public function testDoTransactionStandard()
    {
        $transactionStandard = new Model\TransactionStandard();
        $transactionStandard->setOrderId((string)time())
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
        $gateway->doTransactionStandard($transactionStandard);
    }

}
 