<?php

namespace BlueMedia\OnlinePayments\Tests\Unit\Action\PaywayList;

use BlueMedia\OnlinePayments\Action\PaywayList\GatewayModel;

class GatewayModelTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var GatewayModel
     */
    protected $model;

    protected function _before()
    {
        $this->model = new GatewayModel();
    }

    protected function _after()
    {
        unset($this->model);
    }

    public function testGetGatewayId()
    {
        $this->tester->assertSame(0, $this->model->getGatewayId());
    }

    public function testSetGatewayId()
    {
        $this->tester->assertSame($this->model, $this->model->setGatewayId($this->tester->faker()->randomLetter));
        $this->tester->assertSame(0, $this->model->getGatewayId());

        $value = $this->tester->faker()->randomNumber(1, true);
        $this->tester->assertSame($this->model, $this->model->setGatewayId($value));
        $this->tester->assertSame($value, $this->model->getGatewayId());

        $this->tester->assertSame($this->model, $this->model->setGatewayId('abc'));
        $this->tester->assertSame(0, $this->model->getGatewayId());
    }

    public function testGetGatewayName()
    {
        $this->tester->assertSame('', $this->model->getGatewayName());
    }

    public function testSetGatewayName()
    {
        $this->tester->assertSame($this->model, $this->model->setGatewayName('ABC-XYZ'));
        $this->tester->assertSame('ABC-XYZ', $this->model->getGatewayName());
    }

    public function testGetGatewayType()
    {
        $this->tester->assertSame('', $this->model->getGatewayType());
    }

    public function testSetGatewayType()
    {
        $this->tester->assertSame($this->model, $this->model->setGatewayType('ABC-XYZ'));
        $this->tester->assertSame('ABC-XYZ', $this->model->getGatewayType());
    }

    public function testGetBankName()
    {
        $this->tester->assertSame('', $this->model->getBankName());
    }

    public function testSetBankName()
    {
        $this->tester->assertSame($this->model, $this->model->setBankName('ABC-XYZ'));
        $this->tester->assertSame('ABC-XYZ', $this->model->getBankName());
    }

    public function testGetIconUrl()
    {
        $this->tester->assertSame('', $this->model->getIconUrl());
    }

    public function testSetIconUrl()
    {
        $this->tester->assertSame($this->model, $this->model->setIconUrl('ABC-XYZ'));
        $this->tester->assertSame('ABC-XYZ', $this->model->getIconUrl());
    }

    public function testGetStatusDate()
    {
        $this->tester->assertSame(null, $this->model->getStatusDate());
    }

    public function testSetStatusDate()
    {
        $dateTime = \DateTime::createFromFormat(\DateTime::ATOM, '2017-08-29T11:42:05+02:00');
        $this->tester->assertSame($this->model, $this->model->setStatusDate($dateTime));
        $this->tester->assertSame($dateTime, $this->model->getStatusDate());
    }

    public function testIsCardTrue()
    {
        $this->model->setGatewayId(GatewayModel::GATEWAY_ID_CARD);
        $this->tester->assertTrue($this->model->isCard());
    }

    public function testIsCardFalse()
    {
        $this->model->setGatewayId(GatewayModel::GATEWAY_ID_ING);
        $this->tester->assertFalse($this->model->isCard());
    }

    public function testIsPblTrue()
    {
        $this->model->setGatewayId(GatewayModel::GATEWAY_ID_MTRANSFER);
        $this->tester->assertTrue($this->model->isPbl());
    }

    public function testIsPblFalse()
    {
        $this->model->setGatewayId(GatewayModel::GATEWAY_ID_CARD);
        $this->tester->assertFalse($this->model->isPbl());
    }

    public function testIsTransferTrue()
    {
        $this->model->setGatewayId(GatewayModel::GATEWAY_ID_VOLKSWAGEN_BANK);
        $this->tester->assertTrue($this->model->isTransfer());
    }

    public function testIsTransferFalse()
    {
        $this->model->setGatewayId(GatewayModel::GATEWAY_ID_CARD);
        $this->tester->assertFalse($this->model->isTransfer());
    }

    public function testIsGatewayTrue()
    {
        $this->model->setGatewayId(GatewayModel::GATEWAY_ID_MTRANSFER);
        $this->tester->assertTrue($this->model->isGateway(GatewayModel::GATEWAY_ID_MTRANSFER));
    }

    public function testIsGatewayFalse()
    {
        $this->model->setGatewayId(GatewayModel::GATEWAY_ID_CARD);
        $this->tester->assertFalse($this->model->isGateway(GatewayModel::GATEWAY_ID_MTRANSFER));
    }

    public function testValidate()
    {
        $this->model->setGatewayId(GatewayModel::GATEWAY_ID_CARD);
        $this->model->setGatewayName('NONE');
        $this->tester->assertNull($this->model->validate());
    }
}
