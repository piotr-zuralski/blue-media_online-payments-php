<?php

$model = new \BlueMedia\OnlinePayments\Model\ItnIn();
$model->setServiceId(123456)
    ->setOrderId('148104586')
    ->setRemoteId('96JMMU8K')
    ->setAmount('19258654.98')
    ->setCurrency('PLN')
    ->setGatewayId(106)
    ->setPaymentDate(\DateTime::createFromFormat(\DateTime::ATOM, '2016-12-06T23:55:39+01:00'))
    ->setPaymentStatus('SUCCESS')
    ->setPaymentStatusDetails('AUTHORIZED')
    ->setHash('49344f70b779a64e2610bc046c1f244c2392be30f737384749c59071e443579a');

return $model;
