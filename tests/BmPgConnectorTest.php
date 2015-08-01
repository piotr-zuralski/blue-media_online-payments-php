<?php

namespace BlueMedia\OnlinePayments\Tests;

use BlueMedia\OnlinePayments\BmPgConnector;
use PHPUnit_Framework_TestCase as PHPUnit;

class BmPgConnectorTest extends PHPUnit
{
    public function testExample()
    {
        $bmPgConnector = new BmPgConnector();

        $this->assertTrue(true);
    }
}
