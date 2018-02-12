<?php

$model = new \BlueMedia\OnlinePayments\Model\TransactionStandard();
$model->setOrderId('1507038299')
    ->setAmount('123.45')
    ->setDescription('Test transaction')
    ->setGatewayId(106)
    ->setCurrency('PLN')
    ->setCustomerEmail('test@zuralski.net')
    ->setCustomerNrb('50114020040000360275384788')
    ->setTaxCountry('PL')
    ->setCustomerIp('192.168.0.34')
    ->setTitle('Test transaction 1507038299')
    ->setReceiverName('Zuralski.net');

return $model;
