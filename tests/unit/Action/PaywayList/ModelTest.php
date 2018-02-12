<?php

namespace BlueMedia\OnlinePayments\Tests\Unit\Action\PaywayList;

use BlueMedia\OnlinePayments\Action\PaywayList\Model;

class ModelTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var Model
     */
    protected $model;

    protected function _before()
    {
        $this->model = new Model();
    }

    protected function _after()
    {
        unset($this->model);
    }

    public function testLog()
    {
        $this->markTestIncomplete();
    }
}
