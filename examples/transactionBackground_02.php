<?php

require_once './.config.php';

/**
 * Transaction in background request - example no 2.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @since     2015-08-08
 * @version   2.3.3
 */
use BlueMedia\OnlinePayments\Gateway;
use BlueMedia\OnlinePayments\Model;

$transactionStandard = new Model\TransactionStandard();
$transactionStandard
    ->setOrderId((string) time())
    ->setAmount('9876.54')
    ->setDescription('Test transaction')
    ->setGatewayId(1500)
    ->setCurrency('PLN')
    ->setCustomerEmail('test@example.net')
    ->setCustomerIp('192.168.0.34')
    ->setTitle(sprintf('Zamówienie nr %s', $transactionStandard->getOrderId()))
//    ->setTaxCountry('PL')
    ->setCustomerNrb('39105017641000009217760264')
    ->setReceiverName('Zuralski.net')
;

/** @type Gateway $gateway */
/** @type Model\TransactionBackground $transactionBackground */
$transactionBackground = $gateway->doTransactionBackground($transactionStandard);
var_export($transactionBackground);
