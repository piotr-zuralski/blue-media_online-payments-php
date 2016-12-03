<?php

require_once './../vendor/autoload.php';
require_once './LoggerExample.php';

error_reporting(E_ALL | E_NOTICE | E_DEPRECATED | E_STRICT);
ini_set('display_errors', true);

use BlueMedia\OnlinePayments\Gateway;

/**
 * Common config for examples
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @since     2015-08-08
 * @version   2.3.2
 */

/** @var LoggerExample $loggerExample */
$loggerExample = new LoggerExample();

\BlueMedia\OnlinePayments\Logger::setLogger($loggerExample);

$serviceId = ((!empty($_GET['serviceId'])) ? $_GET['serviceId'] : 100006);
$hashingSeparator = ((!empty($_GET['hashingSeparator'])) ? (string)$_GET['hashingSeparator'] : '');

switch ($serviceId) {
    case '100006':
    default:
        $hashingSalt = '81532ad38b71944834059480537b324bd1ab2bd9';
        break;

    case '100014':
        $hashingSalt = '83b00f00ba6cd33af0b0a9e739e1716a636620f5';
        break;
}

printf('<form action="" method="get">');
printf('<label for="serviceId">serviceId: <select id="serviceId" name="serviceId">
<option value="100006" ' . ('100006' == $serviceId ? 'selected="selected"' : '') . '>100006</option>
<option value="100014" ' . ('100014' == $serviceId ? 'selected="selected"' : '') . '>100014</option>
</select></label> ');
printf('<label for="hashingSeparator">hashingSeparator: <select id="hashingSeparator" name="hashingSeparator">
<option value="" ' . ('' == $hashingSeparator ? 'selected="selected"' : '') . '>""</option>
<option value="|" ' . ('|' == $hashingSeparator? 'selected="selected"' : '') . '>"|"</option>
</select></label> <input type="submit"/></form>');
printf('<code>serviceId: %s, hashingSalt: %s, hashingSeparator: "%s"</code><br>', $serviceId, $hashingSalt, $hashingSeparator);

$gateway = new Gateway($serviceId, $hashingSalt, Gateway::MODE_SANDBOX, 'sha256', $hashingSeparator);
