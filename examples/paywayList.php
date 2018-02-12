<?php

require_once './.config.php';

/**
 * Transaction in background request - example no 1.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @since     2016-11-30
 * @version   2.3.2
 */

/** @var BlueMedia\OnlinePayments\Gateway $gateway */
echo configForm();
try {
    $response = $gateway->doPaywayList();

    /**
     * @var \BlueMedia\OnlinePayments\Action\PaywayList\GatewayModel $paymentGateway
     */
    foreach ($response->getGateways() as $key => $paymentGateway) {
        dump(array($paymentGateway->getGatewayId(), $paymentGateway->getGatewayType(), $paymentGateway->getGatewayName()));
    }
} catch (\Exception $exception) {
    dump($exception);
}

echo '<br>';

/** @var LoggerExample $loggerExample */
dump($loggerExample->getLogStack());
