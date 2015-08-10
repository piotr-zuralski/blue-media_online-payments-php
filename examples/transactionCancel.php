<?php

require_once './.config.php';

use BlueMedia\OnlinePayments\Gateway;
use BlueMedia\OnlinePayments\Model;

$transactionCancel = new Model\TransactionCancel();
$transactionCancel->setOrderId('20150609125812')
    ->setAmount('1.00')
    ->setCurrency('PLN')
;

/** @var Gateway $gateway */
var_dump($gateway->doTransactionCancel($transactionCancel));