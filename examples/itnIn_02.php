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
    $_POST['transactions'] = 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/Pgo8dHJhbnNhY3Rpb25MaXN0PgogICAgPHNlcnZpY2VJRD4xMDAwMTQ8L3NlcnZpY2VJRD4KICAgIDx0cmFuc2FjdGlvbnM+CiAgICAgICAgPHRyYW5zYWN0aW9uPgogICAgICAgICAgICA8b3JkZXJJRD4xNDM4OTUxNTE5PC9vcmRlcklEPgogICAgICAgICAgICA8cmVtb3RlSUQ+OTZMUUozMlM8L3JlbW90ZUlEPgogICAgICAgICAgICA8YW1vdW50PjEyMy4wMDwvYW1vdW50PgogICAgICAgICAgICA8Y3VycmVuY3k+UExOPC9jdXJyZW5jeT4KICAgICAgICAgICAgPGdhdGV3YXlJRD4xMDY8L2dhdGV3YXlJRD4KICAgICAgICAgICAgPHBheW1lbnREYXRlPjIwMTUwODA3MTQ1MjU0PC9wYXltZW50RGF0ZT4KICAgICAgICAgICAgPHBheW1lbnRTdGF0dXM+UEVORElORzwvcGF5bWVudFN0YXR1cz4KICAgICAgICA8L3RyYW5zYWN0aW9uPgogICAgPC90cmFuc2FjdGlvbnM+CiAgICA8aGFzaD4xZmZhMTA4ZmRmYTk0YmNmYzdlYjM5M2I5ODBkOGY1YWQ2YTJlZTMyYzNmODZkMjk2NGM0NzlmMGNkNzZiNTNkPC9oYXNoPgo8L3RyYW5zYWN0aW9uTGlzdD4K';
}

/** @type Gateway $gateway */
/** @type Model\ItnIn $itnIn */
$itnIn = $gateway->doItnIn();

header('Content-Type: application/xml; charset="utf-8"');
echo $gateway->doItnInResponse($itnIn, false);

/** @var LoggerExample $loggerExample */
printf('<!-- %s -->', var_export($loggerExample->getLogStack(), 1));
