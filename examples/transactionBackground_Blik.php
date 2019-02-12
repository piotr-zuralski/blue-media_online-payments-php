<?php

require_once './.config.php';

/**
 * Blik transaction in background request.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2019 Blue Media
 * @since     2019-02-02
 * @version   2.5.0
 */
use BlueMedia\OnlinePayments\Action\PaywayList\GatewayModel;
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
    ->setGatewayId(GatewayModel::GATEWAY_ID_BLIK)
    ;

/** @var Gateway $gateway */
/** @var Model\TransactionBackground $transactionBackground */
echo configForm();
try {
    $response = $gateway->doTransactionBackground($model);
    dump($response);
} catch (\Exception $exception) {
    dump($exception);
}
