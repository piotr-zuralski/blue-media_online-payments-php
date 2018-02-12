<?php

namespace BlueMedia\OnlinePayments\Tests\Unit\Model;

use BlueMedia\OnlinePayments\Model\TransactionBackground;

class TransactionBackgroundTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var TransactionBackground
     */
    protected $model;

    protected function _before()
    {
        $this->model = new TransactionBackground();
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
