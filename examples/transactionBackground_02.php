<?php

require_once './.config.php';

/**
 * Transaction in background request - example no 2.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @since     2015-08-08
 * @version   2.3.2
 */
use BlueMedia\OnlinePayments\Gateway;
use BlueMedia\OnlinePayments\Model;

$transactionStandard = new Model\TransactionStandard();
$transactionStandard->setOrderId((string) time())
    ->setAmount('9876.54')
    ->setDescription('Test transaction')
    ->setGatewayId(106)
    ->setCurrency('PLN')
    ->setCustomerEmail('test@zuralski.net')
    ->setCustomerNrb('50114020040000360275384788')
    ->setCustomerIp('192.168.0.34')
    ->setTitle(sprintf('Test transaction %s', $transactionStandard->getOrderId()))
    ->setReceiverName('Zuralski.net')
;

/** @type Gateway $gateway */
/** @type Model\TransactionBackground $transactionBackground */
$transactionBackground = $gateway->doTransactionBackground($transactionStandard);

var_export($transactionBackground);
