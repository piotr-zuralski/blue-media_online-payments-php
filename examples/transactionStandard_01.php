<?php

require_once './.config.php';

/**
 * Transaction standard request - example no 1.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @since     2015-08-08
 * @version   2.3.3
 */
use BlueMedia\OnlinePayments\Gateway;
use BlueMedia\OnlinePayments\Model;

$transactionStandard = new Model\TransactionStandard();
$transactionStandard->setOrderId((string) time())
    ->setAmount('12.95')
    ->setDescription('Test transaction')
    ->setCurrency('PLN')
    ->setCustomerEmail('test@example.net')
    ->setCustomerNrb('39105017641000009217760264')
    ->setCustomerIp('192.168.0.34')
    ->setTitle(sprintf('Test transaction %s', $transactionStandard->getOrderId()))
    ->setReceiverName('Zuralski.net')
    ->setValidityTime((new DateTime())->modify('+3days'))
    ->setLinkValidityTime((new DateTime())->modify('+3days'))
;

if (!empty($gatewayId)) {
    $model->setGatewayId($gatewayId);
}

/** @var Gateway $gateway */
echo configForm();
try {
    $response = $gateway->doTransactionStandard($transactionStandard);
    dump($response);
} catch (\Exception $exception) {
    dump($exception);
}
