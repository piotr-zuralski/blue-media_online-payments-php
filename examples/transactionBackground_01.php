<?php

require_once './.config.php';

/**
 * Transaction in background request - example no 1.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @since     2015-08-08
 * @version   2.3.3
 */
use BlueMedia\OnlinePayments\Gateway;
use BlueMedia\OnlinePayments\Model;

$model = new Model\TransactionStandard();
$model
    ->setOrderId((string) time())
    ->setAmount('12.95')
    ->setDescription('Test transaction')
    ->setCurrency('PLN')
    ->setCustomerEmail('test@example.net')
    ->setCustomerIp('192.168.0.34')
    ->setTitle(sprintf('Zamówienie nr %s', $model->getOrderId()))
    ->setCustomerNrb('39105017641000009217760264')
    ->setReceiverName('Zuralski.net')
    ->setValidityTime((new DateTime())->modify('+3days'))
    ->setLinkValidityTime((new DateTime())->modify('+3days'))
;
if (!empty($gatewayId)) {
    $model->setGatewayId($gatewayId);
}

if ($serviceId !== 100006 && $serviceId !== 100014) {
    $model->setTaxCountry('PL');
}

/** @var Gateway $gateway */
/** @var Model\TransactionBackground $transactionBackground */
echo configForm();
try {
    $response = $gateway->doTransactionBackground($model);
    dump($response);
} catch (\Exception $exception) {
    dump($exception);
}
