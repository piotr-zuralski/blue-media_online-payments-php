<?php

$_GET['serviceId'] = '100014';

require_once './.config.php';

use BlueMedia\OnlinePayments\Gateway;
use BlueMedia\OnlinePayments\Model;

/**
 * Incoming ITN request - example no 3.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @since     2016-12-06
 * @version   2.3.3
 */

/* simulates incoming request */
if (empty($_POST['transactions'])) {
    $_POST['transactions'] = 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/Pgo8dHJhbnNhY3Rpb25MaXN0PgogICAgPHNlcnZpY2VJRD4xMDA2NjA8L3NlcnZpY2VJRD4KICAgIDx0cmFuc2FjdGlvbnM+CiAgICAgICAgPHRyYW5zYWN0aW9uPgogICAgICAgICAgICA8b3JkZXJJRD4xNDgxMDY0OTI3PC9vcmRlcklEPgogICAgICAgICAgICA8cmVtb3RlSUQ+OTZKTVNVOEs8L3JlbW90ZUlEPgogICAgICAgICAgICA8YW1vdW50Pjk4NzcuNTQ8L2Ftb3VudD4KICAgICAgICAgICAgPGN1cnJlbmN5PlBMTjwvY3VycmVuY3k+CiAgICAgICAgICAgIDxnYXRld2F5SUQ+MTA2PC9nYXRld2F5SUQ+CiAgICAgICAgICAgIDxwYXltZW50RGF0ZT4yMDE2MTIwNjIzNTUzOTwvcGF5bWVudERhdGU+CiAgICAgICAgICAgIDxwYXltZW50U3RhdHVzPlNVQ0NFU1M8L3BheW1lbnRTdGF0dXM+CiAgICAgICAgICAgIDxwYXltZW50U3RhdHVzRGV0YWlscz5BVVRIT1JJWkVEPC9wYXltZW50U3RhdHVzRGV0YWlscz4KICAgICAgICAgICAgPGFkZHJlc3NJUD4xOTIuMTY4LjAuMzQ8L2FkZHJlc3NJUD4KICAgICAgICAgICAgPHRpdGxlPkJQSUQ6OTZKTVNVOEsgVGVzdCB0cmFuc2FjdGlvbjwvdGl0bGU+CiAgICAgICAgICAgIDxjdXN0b21lckRhdGE+CiAgICAgICAgICAgICAgICA8Zk5hbWU+SmFuPC9mTmFtZT4KICAgICAgICAgICAgICAgIDxsTmFtZT5Lb3dhbHNraTwvbE5hbWU+CiAgICAgICAgICAgICAgICA8c3RyZWV0TmFtZT5KYXNuYTwvc3RyZWV0TmFtZT4KICAgICAgICAgICAgICAgIDxzdHJlZXRIb3VzZU5vPjY8L3N0cmVldEhvdXNlTm8+CiAgICAgICAgICAgICAgICA8c3RyZWV0U3RhaXJjYXNlTm8+QTwvc3RyZWV0U3RhaXJjYXNlTm8+CiAgICAgICAgICAgICAgICA8c3RyZWV0UHJlbWlzZU5vPjM8L3N0cmVldFByZW1pc2VObz4KICAgICAgICAgICAgICAgIDxwb3N0YWxDb2RlPjEwLTIzNDwvcG9zdGFsQ29kZT4KICAgICAgICAgICAgICAgIDxjaXR5PldhcnN6YXdhPC9jaXR5PgogICAgICAgICAgICAgICAgPG5yYj4yNjEwNTAxNDQ1MTAwMDAwMjI3NjQ3MDQ2MTwvbnJiPgogICAgICAgICAgICAgICAgPHNlbmRlckRhdGE+SmFuIEtvd2Fsc2tpIEphc25hIDYvQS8zIDEwLTIzNCBXYXJzemF3YTwvc2VuZGVyRGF0YT4KICAgICAgICAgICAgPC9jdXN0b21lckRhdGE+CiAgICAgICAgICAgIDxzdGFydEFtb3VudD45ODc2LjU0PC9zdGFydEFtb3VudD4KICAgICAgICA8L3RyYW5zYWN0aW9uPgogICAgPC90cmFuc2FjdGlvbnM+CiAgICA8aGFzaD5mYzc4N2E0ODJlOWJkMGY3MDcyMjNkZTNjNjg3YTk2ZjNmOWEzZWQ4OTIyZDgyOTFhNWRmYzA2MWE5OTdmYjIwPC9oYXNoPgo8L3RyYW5zYWN0aW9uTGlzdD4K';
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
