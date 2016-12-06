<?php

namespace BlueMedia\OnlinePayments;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * Logger proxy.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments
 * @since     2016-01-10
 * @version   2.3.2
 */
class Logger
{
    const EMERGENCY = LogLevel::EMERGENCY;
    const ALERT     = LogLevel::ALERT;
    const CRITICAL  = LogLevel::CRITICAL;
    const ERROR     = LogLevel::ERROR;
    const WARNING   = LogLevel::WARNING;
    const NOTICE    = LogLevel::NOTICE;
    const INFO      = LogLevel::INFO;
    const DEBUG     = LogLevel::DEBUG;

    /** @type LoggerInterface */
    protected static $logger;

    /**
     * Sets a logger.
     *
     * @api
     *
     * @param LoggerInterface $logger
     */
    public static function setLogger(LoggerInterface $logger)
    {
        self::$logger = $logger;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @api
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return bool|null
     */
    public static function log($level, $message, array $context = [])
    {
        if (is_object(self::$logger) && self::$logger instanceof LoggerInterface) {
            return self::$logger->log($level, $message, $context);
        }

        return false;
    }
}
