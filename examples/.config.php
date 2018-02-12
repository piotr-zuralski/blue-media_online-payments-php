<?php

require_once './../vendor/autoload.php';
require_once './LoggerExample.php';

error_reporting(-1);
ini_set('display_errors', true);

if (class_exists('\Symfony\Component\VarDumper\VarDumper')) {
    $cloner = new \Symfony\Component\VarDumper\Cloner\VarCloner();
    $cloner->setMaxItems(-1);
    $cloner->setMaxString(-1);

    $dumper = new \Symfony\Component\VarDumper\Dumper\HtmlDumper();
    $dumper->setDisplayOptions([
        'maxDepth' => 512,
        'maxStringLength' => 128,
    ]);

    \Symfony\Component\VarDumper\VarDumper::setHandler(
        function ($var) use ($cloner, $dumper) {
            $dumper->dump($cloner->cloneVar($var));
        }
    );
}

use BlueMedia\OnlinePayments\Gateway;

/**
 * Common config for examples
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @since     2015-08-08
 * @version   2.3.3
 */

/** @var LoggerExample $loggerExample */
$loggerExample = new LoggerExample();

\BlueMedia\OnlinePayments\Logger::setLogger($loggerExample);

$serviceId = ((!empty($_GET['serviceId'])) ? $_GET['serviceId'] : 100660);
$gatewayId = ((!empty($_GET['gatewayId'])) ? $_GET['gatewayId'] : '');

switch ($serviceId) {
    case '100006':
        $hashingSalt = '81532ad38b71944834059480537b324bd1ab2bd9';
        $hashingSeparator = '|';
        break;

    case '100014':
        $hashingSalt = '83b00f00ba6cd33af0b0a9e739e1716a636620f5';
        $hashingSeparator = '';
        break;

    case '100660':
        $hashingSalt = 'fb7533465e669d836812fd1e4357240e03edbef6';
        $hashingSeparator = '|';
        break;

    default:
        $serviceId = '100660';
        $hashingSalt = 'fb7533465e669d836812fd1e4357240e03edbef6';
        $hashingSeparator = '|';
        break;
}

function configForm()
{
    global $serviceId, $hashingSalt, $hashingSeparator, $gatewayId;

    $result  = sprintf('<form action="" method="get">');
    $result .= sprintf(' <label for="serviceId">serviceId: <select id="serviceId" name="serviceId">
    <option value="100006" ' . ('100006' == $serviceId ? 'selected="selected"' : '') . '>100006</option>
    <option value="100014" ' . ('100014' == $serviceId ? 'selected="selected"' : '') . '>100014</option>
    <option value="100660" ' . ('100660' == $serviceId ? 'selected="selected"' : '') . '>100660</option>
    </select></label> ');
    $result .= sprintf(' <label for="gatewayId">gatewayId: <select id="gatewayId" name="gatewayId">
    <option value="1500" ' . ('1500' == $gatewayId ? 'selected="selected"' : '') . '>PBL - PBC płatność testowa (1500)</option>
    <option value="106" ' . ('106' == $gatewayId ? 'selected="selected"' : '') . '>PBL - PG płatność testowa (106)</option>
    <option value="21" ' . ('21' == $gatewayId ? 'selected="selected"' : '') . '>Szybki przelew - Przelew Volkswagen Bank (21)</option>
    <option value="35" ' . ('35' == $gatewayId ? 'selected="selected"' : '') . '>Szybki przelew - Spółdzielcza Grupa Bankowa (35)</option>
    <option value="50" ' . ('50' == $gatewayId ? 'selected="selected"' : '') . '>Szybki przelew - Przelew Getin Bank (50)</option>
    <option value="71" ' . ('71' == $gatewayId ? 'selected="selected"' : '') . '>Szybki przelew - Przelew BGŻ (71)</option>
    <option value="1017" ' . ('1017' == $gatewayId ? 'selected="selected"' : '') . '>Szybki przelew - Przelew Bank Pocztowy (1017)</option>
    <option value="9" ' . ('9' == $gatewayId ? 'selected="selected"' : '') . '>Szybki przelew - Przelew z innego banku (9)</option>
    </select></label> ');
    $result .= sprintf(' <input type="submit"/></form>');
    $result .= sprintf('<code>serviceId: %s, hashingSalt: %s, hashingSeparator: "%s", gatewayId: "%s"</code><br>', $serviceId, $hashingSalt, $hashingSeparator, $gatewayId);

    return $result;
}

$gateway = new Gateway($serviceId, $hashingSalt, Gateway::MODE_SANDBOX, 'sha256', $hashingSeparator);
