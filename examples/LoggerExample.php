<?php

use Psr\Log\AbstractLogger;

/**
 * Example logger object, just for demo.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2016 Blue Media
 * @since     2016-01-18
 * @version   2.3.2
 */
class LoggerExample extends AbstractLogger
{
    private $logStack = [];

    /**
     * Logs with an arbitrary level.
     *
     * @param  mixed  $level
     * @param  string $message
     * @param  array  $context
     * @return null
     */
    public function log($level, $message, array $context = [])
    {
        array_push($this->logStack, [
            'level'     => $level,
            'message'   => $message,
            'context'   => $context,
        ]);
    }

    public function getLogStack()
    {
        return $this->logStack;
    }
}
