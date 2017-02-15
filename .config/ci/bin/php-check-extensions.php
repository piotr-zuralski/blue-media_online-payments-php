<?php

require_once dirname(__FILE__ ) . '/php-version.php';

echo "\n";

$extensions = array(
    ((version_compare($phpversion, '7.0', 'ge')) ? 'apcu' : 'apc'),
    // 'bcmath',
    'bz2',
    // 'calendar',
    'curl',
    'dom',
    // 'exif',
    // 'fileinfo',
    'filter',
    // 'gd',
    // 'gettext',
    'hash',
    'iconv',
    // 'imagick',
    'intl',
    'json',
    // 'ldap',
    'mbstring',
    'mcrypt',
    // 'memcached',
    'openssl',
    // 'pcntl',
    // 'pdo',
    'phar',
    // 'redis',
    'session',
    'simplexml',
    // 'soap',
    // 'tidy',
    'xmlreader',
    'xmlwriter',
    // 'xsl',
    // 'zend opcache',
    // 'zip',
    // 'xdebug',
    // 'zmq',
    // 'amqp',
    // 'gnupg',
);

printf("PHP version: %s\n", $phpversion);
$success = true;
foreach ($extensions as $extension) {
    $hasExtension = extension_loaded($extension);
    if (!$hasExtension && $success) {
        $success = false;
    }
    printf("%s: %d\n", $extension, $hasExtension);
}

if (!$success) {
    throw new RuntimeException('Not all extensions available');
}
