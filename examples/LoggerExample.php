<?php

use Psr\Log\AbstractLogger;

/**
 * Example logger object, just for demo.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2016 Blue Media
 * @since     2016-01-18
 * @version   2.3.3
 */
class LoggerExample extends AbstractLogger
{
    private $logStack = array();

    /**
     * Logs with an arbitrary level.
     *
     * @param  mixed  $level
     * @param  string $message
     * @param  array  $context
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        $data = array(
            'datetime'  => date(DateTime::ATOM),
            'level'     => $level,
            'message'   => $message,
            'context'   => $context,
        );

        array_push($this->logStack, $data);
        file_put_contents(
            sprintf('%s/log-%s.log', dirname(__FILE__), date('Y-m-d')),
            json_encode(var_export($data, true)) . PHP_EOL,
            FILE_APPEND
        );
    }

    public function getLogStack()
    {
        return $this->logStack;
    }
}
