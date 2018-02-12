<?php

namespace BlueMedia\OnlinePayments\Tests\Unit\Model;

use BlueMedia\OnlinePayments\Model\ItnIn;

class ItnInTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var ItnIn
     */
    protected $model;

    protected function _before()
    {
        $this->model = new ItnIn();
    }

    protected function _after()
    {
        unset($this->model);
    }

    // tests
    public function testLog()
    {
        $this->markTestIncomplete();
    }
}
