<?php

$model = new \BlueMedia\OnlinePayments\Model\ItnIn();
$model->setServiceId(100660)
    ->setOrderId('1481064927')
    ->setRemoteId('96JMSU8K')
    ->setAmount('199.95')
    ->setCurrency('PLN')
    ->setGatewayId(106)
    ->setPaymentDate(\DateTime::createFromFormat(\DateTime::ATOM, '2016-12-06T23:55:39+01:00'))
    ->setPaymentStatus('PENDING')
    ->setStartAmount('199.95')
    ->setHash('2f006dd1ed8c242ac960213cbafd6679ff9f1095805e04eb56f96cc67e51e5f4');

return $model;
