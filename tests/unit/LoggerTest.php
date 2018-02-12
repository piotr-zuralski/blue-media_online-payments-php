<?php

namespace BlueMedia\OnlinePayments\Tests\Unit;

use BlueMedia\OnlinePayments\Logger;
use Codeception\Util\Stub;
use Psr\Log\NullLogger;

class LoggerTest extends \Codeception\Test\Unit
{
    public function testLogShouldReturnNothingWhenLoggerHandlerIsPresent()
    {
        Logger::setLogger(new NullLogger());
        $this->tester->assertNull(Logger::log(Logger::ALERT, 'test message'));
    }

    public function testLogShouldReturnNullWhenNoLogger()
    {
        $logger = Stub::make(Logger::class, array('logger' => null));
        $this->tester->assertNull($logger::log(Logger::ALERT, 'test message'));
    }
}
