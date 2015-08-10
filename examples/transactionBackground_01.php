<?php

require_once './.config.php';

use BlueMedia\OnlinePayments\Gateway;
use BlueMedia\OnlinePayments\Model;

$transactionStandard = new Model\TransactionStandard();
$transactionStandard->setOrderId((string)time())
    ->setAmount('9876.54')
    ->setDescription('Test transaction')
    ->setGatewayId(71)
    ->setCurrency('PLN')
    ->setCustomerEmail('test@zuralski.net')
    ->setCustomerNrb('50114020040000360275384788')
    ->setCustomerIp('192.168.0.34')
    ->setTitle(sprintf('Test transaction %s', $transactionStandard->getOrderId()))
    ->setReceiverName('Zuralski.net')
    ->setValidityTime((new DateTime())->modify('+3days'))
    ->setLinkValidityTime((new DateTime())->modify('+3days'))
;

/** @var Gateway $gateway */
/** @var Model\TransactionBackground $transactionBackground */
$transactionBackground = $gateway->doTransactionBackground($transactionStandard);

var_dump($transactionBackground);