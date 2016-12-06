<?php

require_once './.config.php';

use BlueMedia\OnlinePayments\Gateway;
use BlueMedia\OnlinePayments\Model;

/**
 * Incoming ITN request - example no 2.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @since     2015-08-08
 * @version   2.3.2
 */

/* simulates incoming request */
if (empty($_POST['transactions'])) {
    $_POST['transactions'] = 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/Pgo8dHJhbnNhY3Rpb25MaXN0PgogICAgPHNlcnZpY2VJRD4xMDA2NjA8L3NlcnZpY2VJRD4KICAgIDx0cmFuc2FjdGlvbnM+CiAgICAgICAgPHRyYW5zYWN0aW9uPgogICAgICAgICAgICA8b3JkZXJJRD4xNDgxMDY0OTc1PC9vcmRlcklEPgogICAgICAgICAgICA8cmVtb3RlSUQ+OTZKTVRCNFo8L3JlbW90ZUlEPgogICAgICAgICAgICA8YW1vdW50Pjk4NzcuNTQ8L2Ftb3VudD4KICAgICAgICAgICAgPGN1cnJlbmN5PlBMTjwvY3VycmVuY3k+CiAgICAgICAgICAgIDxnYXRld2F5SUQ+MTA2PC9nYXRld2F5SUQ+CiAgICAgICAgICAgIDxwYXltZW50RGF0ZT4yMDE2MTIwNjIzNTYwNzwvcGF5bWVudERhdGU+CiAgICAgICAgICAgIDxwYXltZW50U3RhdHVzPlBFTkRJTkc8L3BheW1lbnRTdGF0dXM+CiAgICAgICAgICAgIDxhZGRyZXNzSVA+MTkyLjE2OC4wLjM0PC9hZGRyZXNzSVA+CiAgICAgICAgICAgIDxzdGFydEFtb3VudD45ODc2LjU0PC9zdGFydEFtb3VudD4KICAgICAgICA8L3RyYW5zYWN0aW9uPgogICAgPC90cmFuc2FjdGlvbnM+CiAgICA8aGFzaD43M2U0NTQ0Y2IwMmE4YjYzMDAwZGEwYjA1NzM4NDk2MmQzZjJlMzA3OWJmMDY4Mzc3ZTNhNjgwMjM5M2I5ODI2PC9oYXNoPgo8L3RyYW5zYWN0aW9uTGlzdD4K';
}

header('Content-Type: application/xml; charset="utf-8"');
try {
    /** @type Gateway $gateway */
    /** @type Model\ItnIn $itnIn */
    $itnIn = $gateway->doItnIn();

    echo $gateway->doItnInResponse($itnIn);
} catch (Exception $exception) {
    header('HTTP/1.1 400 Bad Request');
    printf('<!-- %s -->', $exception->getMessage());
}

printf('<!-- %s -->', var_export(configForm(), 1));

/** @var LoggerExample $loggerExample */
printf('<!-- %s -->', var_export($loggerExample->getLogStack(), 1));
