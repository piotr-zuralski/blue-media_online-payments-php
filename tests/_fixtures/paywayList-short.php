<?php

$model = new \BlueMedia\OnlinePayments\Action\PaywayList\Model();
$model->setServiceId(123456)
    ->setMessageId('88d5d66ac8579d344154156f286e4da3')
    ->setHash('4d4132bb905a40af78914a32ad70f8c9b217d05a045c5ceb6b25db0fc9e49607')
    ->addGateway(
        (new \BlueMedia\OnlinePayments\Action\PaywayList\GatewayModel())
        ->setGatewayId(106)
        ->setGatewayName('PG płatność testowa')
        ->setGatewayType('PBL')
        ->setBankName('NONE')
        ->setIconUrl('https://platnosci.bm.pl/pomoc/grafika/106.gif')
        ->setStatusDate(\DateTime::createFromFormat(\DateTime::ATOM, '2017-08-29T11:42:05+02:00'))
    )
    ->addGateway(
        (new \BlueMedia\OnlinePayments\Action\PaywayList\GatewayModel())
            ->setGatewayId(21)
            ->setGatewayName('Przelew Volkswagen Bank')
            ->setGatewayType('Szybki przelew')
            ->setBankName('NONE')
            ->setIconUrl('https://platnosci.bm.pl/pomoc/grafika/21.gif')
            ->setStatusDate(\DateTime::createFromFormat(\DateTime::ATOM, '2017-08-29T11:42:05+02:00'))
    )
;

return $model;
