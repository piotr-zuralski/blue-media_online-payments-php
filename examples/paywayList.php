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
/** @type Gateway $gateway */
$response = $gateway->doPaywayList();
dump($response);

echo '<br>';

/** @var LoggerExample $loggerExample */
dump($loggerExample->getLogStack());
