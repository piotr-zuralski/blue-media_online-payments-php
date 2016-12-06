<?php

require_once './../vendor/autoload.php';
require_once './LoggerExample.php';

error_reporting(-1);
ini_set('display_errors', true);
ini_set('xdebug.var_display_max_children', 128);
ini_set('xdebug.var_display_max_data', 512);
ini_set('xdebug.var_display_max_depth', 100);

//if (class_exists('\Symfony\Component\VarDumper\VarDumper')) {
    $cloner = new \Symfony\Component\VarDumper\Cloner\VarCloner();
    $cloner->setMaxItems(-1);
    $cloner->setMaxString(-1);

    $dumper = new \Symfony\Component\VarDumper\Dumper\HtmlDumper();
    $dumper->setDisplayOptions([
        'maxDepth' => ini_get('xdebug.var_display_max_depth'),
        'maxStringLength' => ini_get('xdebug.var_display_max_data'),
    ]);

    \Symfony\Component\VarDumper\VarDumper::setHandler(
        function ($var) use ($cloner, $dumper) {
            $dumper->dump($cloner->cloneVar($var));
        }
    );
//}

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

$serviceId = ((!empty($_GET['serviceId'])) ? $_GET['serviceId'] : 100660);
$hashingSeparator = ((!empty($_GET['hashingSeparator'])) ? (string)$_GET['hashingSeparator'] : '');

switch ($serviceId) {
    case '100006':
        $hashingSalt = '81532ad38b71944834059480537b324bd1ab2bd9';
        $hashingSeparator = '|';
        break;

    case '100014':
        $hashingSalt = '83b00f00ba6cd33af0b0a9e739e1716a636620f5';
        break;

    case '100660':
    default:
        $serviceId = '100660';
        $hashingSalt = 'fb7533465e669d836812fd1e4357240e03edbef6';
        $hashingSeparator = '|';
        break;
}

function configForm()
{
    global $serviceId, $hashingSalt, $hashingSeparator;

    $result  = sprintf('<form action="" method="get">');
    $result .= sprintf('<label for="serviceId">serviceId: <select id="serviceId" name="serviceId">
    <option value="100006" ' . ('100006' == $serviceId ? 'selected="selected"' : '') . '>100006</option>
    <option value="100014" ' . ('100014' == $serviceId ? 'selected="selected"' : '') . '>100014</option>
    <option value="100660" ' . ('100660' == $serviceId ? 'selected="selected"' : '') . '>100660</option>
    </select></label> ');
    $result .= sprintf('<label for="hashingSeparator">hashingSeparator: <select id="hashingSeparator" name="hashingSeparator">
    <option value="" ' . ('' == $hashingSeparator ? 'selected="selected"' : '') . '>""</option>
    <option value="|" ' . ('|' == $hashingSeparator? 'selected="selected"' : '') . '>"|"</option>
    </select></label> <input type="submit"/></form>');
    $result .= sprintf('<code>serviceId: %s, hashingSalt: %s, hashingSeparator: "%s"</code><br>', $serviceId, $hashingSalt, $hashingSeparator);
    return $result;
}

$gateway = new Gateway($serviceId, $hashingSalt, Gateway::MODE_SANDBOX, 'sha256', $hashingSeparator);
