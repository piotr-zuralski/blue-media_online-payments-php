<?php

use BlueMedia\OnlinePayments\Action\PaywayList\GatewayModel;

use League\FactoryMuffin\Faker\Facade as Faker;

Faker::setLocale('pl_PL');

Faker::define(GatewayModel::class)->setDefinitions(array(
    'gatewayId'     => Faker::randomNumber(1),
    'gatewayName'   => Faker::sentence(),
    'gatewayType'   => Faker::text(),
    'bankName'      => Faker::randomNumber(8),
    'iconUrl'       => Faker::date('Ymd h:s'),
    'statusDate'    => 'Message::makeSlug',
));

//$fm->define('User')->setDefinitions([
//    'username' => Faker::firstNameMale(),
//    'email'    => Faker::email(),
//    'avatar'   => Faker::imageUrl(400, 600),
//    'greeting' => 'RandomGreeting::get',
//    'four'     => function() {
//        return 2 + 2;
//    },
//]);
