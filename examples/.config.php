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

//$gateway = new Gateway('100014', '83b00f00ba6cd33af0b0a9e739e1716a636620f5', Gateway::MODE_SANDBOX, 'sha256', '');
$gateway = new Gateway('100006', '81532ad38b71944834059480537b324bd1ab2bd9', Gateway::MODE_SANDBOX, 'sha256', '');

