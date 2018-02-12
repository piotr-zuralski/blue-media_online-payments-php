<?php

namespace BlueMedia\OnlinePayments\Tests\Unit\Model;

use BlueMedia\OnlinePayments\Model\TransactionStandard;

class TransactionStandardTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var TransactionStandard
     */
    protected $model;

    protected function _before()
    {
        $this->model = new TransactionStandard();
    }

    protected function _after()
    {
        unset($this->model);
    }

    // tests
    public function testGetAmount()
    {
        $this->tester->assertSame('0.00', $this->model->getAmount());
    }

    public function testSetAmount()
    {
        $this->tester->assertSame($this->model, $this->model->setAmount(123.25));
        $this->tester->assertSame('123.25', $this->model->getAmount());
    }

    public function testGetCurrency()
    {
        $this->tester->assertSame(null, $this->model->getCurrency());
    }

    public function testSetCurrency()
    {
        $this->tester->assertSame($this->model, $this->model->setCurrency('abc'));
        $this->tester->assertSame('ABC', $this->model->getCurrency());
    }

    public function testGetCustomerEmail()
    {
        $this->tester->assertSame(null, $this->model->getCustomerEmail());
    }

    public function testSetCustomerEmail()
    {
        $this->tester->assertSame($this->model, $this->model->setCustomerEmail('ABC@ABC.AB'));
        $this->tester->assertSame('abc@abc.ab', $this->model->getCustomerEmail());
    }

    public function testGetCustomerIp()
    {
        $this->tester->assertSame(null, $this->model->getCustomerIp());
    }

    public function testSetCustomerIp()
    {
        $this->tester->assertSame($this->model, $this->model->setCustomerIp('192.168.0.1'));
        $this->tester->assertSame('192.168.0.1', $this->model->getCustomerIp());
    }

    public function testGetCustomerNrb()
    {
        $this->tester->assertSame(null, $this->model->getCustomerNrb());
    }

    public function testSetCustomerNrb()
    {
        $this->tester->assertSame($this->model, $this->model->setCustomerNrb('57114020040000300234463178'));
        $this->tester->assertSame('57114020040000300234463178', $this->model->getCustomerNrb());
    }

    public function testGetDescription()
    {
        $this->tester->assertSame(null, $this->model->getDescription());
    }

    public function testSetDescription()
    {
        $this->tester->assertSame($this->model, $this->model->setDescription('ABC'));
        $this->tester->assertSame('ABC', $this->model->getDescription());
    }

    public function testGetGatewayId()
    {
        $this->tester->assertSame(null, $this->model->getGatewayId());
    }

    public function testSetGatewayId()
    {
        $this->tester->assertSame($this->model, $this->model->setGatewayId('12345'));
        $this->tester->assertSame(12345, $this->model->getGatewayId());
    }

    public function testGetHash()
    {
        $this->tester->assertSame(null, $this->model->getHash());
    }

    public function testSetHash()
    {
        $this->tester->assertSame($this->model, $this->model->setHash('abc1234ldp'));
        $this->tester->assertSame('abc1234ldp', $this->model->getHash());
    }

    public function testGetOrderId()
    {
        $this->tester->assertSame(null, $this->model->getOrderId());
    }

    public function testSetOrderId()
    {
        $this->tester->assertSame($this->model, $this->model->setOrderId('abc1234ldp'));
        $this->tester->assertSame('abc1234ldp', $this->model->getOrderId());
    }

    public function testGetLinkValidityTime()
    {
        $this->tester->assertSame(null, $this->model->getLinkValidityTime());
    }

    public function testSetLinkValidityTime()
    {
        $dateTime = \DateTime::createFromFormat(\DateTime::ATOM, '2017-08-29T11:42:05+02:00');
        $this->tester->assertSame($this->model, $this->model->setLinkValidityTime($dateTime));
        $this->tester->assertSame($dateTime, $this->model->getLinkValidityTime());
    }

    public function testGetValidityTime()
    {
        $this->tester->assertSame(null, $this->model->getValidityTime());
    }

    public function testSetValidityTime()
    {
        $dateTime = \DateTime::createFromFormat(\DateTime::ATOM, '2017-08-29T11:42:05+02:00');
        $this->tester->assertSame($this->model, $this->model->setValidityTime($dateTime));
        $this->tester->assertSame($dateTime, $this->model->getValidityTime());
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionCode 0
     * @expectedExceptionMessage ServiceId cannot be empty
     */
    public function testValidateThrowsExceptionServiceId()
    {
        $this->model->validate();
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionCode 0
     * @expectedExceptionMessage OrderId cannot be empty
     */
    public function testValidateThrowsExceptionOrderId()
    {
        $this->model->setServiceId(123456);
        $this->model->validate();
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionCode 0
     * @expectedExceptionMessage Amount cannot be empty
     */
    public function testValidateThrowsExceptionAmount()
    {
        $this->model->setServiceId(123456);
        $this->model->setOrderId('abc123456');
        $this->model->validate();
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionCode 0
     * @expectedExceptionMessage Hash cannot be empty
     */
    public function testValidateThrowsExceptionHash()
    {
        $this->model->setServiceId(123456);
        $this->model->setOrderId('O123456');
        $this->model->setAmount(123.45);
        $this->model->validate();
    }

    public function testValidate()
    {
        $this->model->setServiceId(123456);
        $this->model->setOrderId('abc123456');
        $this->model->setAmount(123.45);
        $this->model->setHash('fdfdsfsf');
        $this->tester->assertNull($this->model->validate());
    }
}
