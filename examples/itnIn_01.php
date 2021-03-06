<?php

require_once './.config.php';

use BlueMedia\OnlinePayments\Gateway;
use BlueMedia\OnlinePayments\Model;

/**
 * Incoming ITN request - example no 1.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @since     2015-08-08
 * @version   2.3.3
 */

/* simulates incoming request */
if (empty($_POST['transactions'])) {
    $_POST['transactions'] = 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/Pgo8dHJhbnNhY3Rpb25MaXN0PgogICAgPHNlcnZpY2VJRD4xMDAwMTQ8L3NlcnZpY2VJRD4KICAgIDx0cmFuc2FjdGlvbnM+CiAgICAgICAgPHRyYW5zYWN0aW9uPgogICAgICAgICAgICA8b3JkZXJJRD4xNDM4OTUwMzY0PC9vcmRlcklEPgogICAgICAgICAgICA8cmVtb3RlSUQ+OTZMUUo3RjI8L3JlbW90ZUlEPgogICAgICAgICAgICA8YW1vdW50PjEyMy4wMDwvYW1vdW50PgogICAgICAgICAgICA8Y3VycmVuY3k+UExOPC9jdXJyZW5jeT4KICAgICAgICAgICAgPGdhdGV3YXlJRD4xMDY8L2dhdGV3YXlJRD4KICAgICAgICAgICAgPHBheW1lbnREYXRlPjIwMTUwODA3MTQyNjQ5PC9wYXltZW50RGF0ZT4KICAgICAgICAgICAgPHBheW1lbnRTdGF0dXM+RkFJTFVSRTwvcGF5bWVudFN0YXR1cz4KICAgICAgICAgICAgPHBheW1lbnRTdGF0dXNEZXRhaWxzPlJFSkVDVEVEPC9wYXltZW50U3RhdHVzRGV0YWlscz4KICAgICAgICA8L3RyYW5zYWN0aW9uPgogICAgPC90cmFuc2FjdGlvbnM+CiAgICA8aGFzaD5jNjEwNmQyMzBjZjFhOTRlMDA4MTc2NWRlMmRmMzI3MWE0MzI3YmI3ZTBmY2Q4ZDc2Y2E2MzRhMTIxYjlhNWIxPC9oYXNoPgo8L3RyYW5zYWN0aW9uTGlzdD4K';
}

header('Content-Type: application/xml; charset="utf-8"');
try {
    /** @var Gateway $gateway */
    /** @var Model\ItnIn $itnIn */
    $itnIn = $gateway->doItnIn();

    echo $gateway->doItnInResponse($itnIn);
} catch (Exception $exception) {
    header('HTTP/1.1 400 Bad Request');
    printf('<!-- %s -->', $exception->getMessage());
}

/** @var LoggerExample $loggerExample */
printf('<!-- %s -->', var_export($loggerExample->getLogStack(), 1));
