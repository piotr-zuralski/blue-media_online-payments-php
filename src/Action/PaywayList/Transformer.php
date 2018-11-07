<?php

namespace BlueMedia\OnlinePayments\Action\PaywayList;

use BlueMedia\OnlinePayments\Gateway;
use DateTime;
use DateTimeZone;
use SimpleXMLElement;

class Transformer
{
    /**
     * Transforms model into an array.
     *
     * @param  Model $model
     * @return array
     */
    public static function modelToArray(Model $model)
    {
        $result = array();
        $result['serviceID'] = $model->getServiceId();
        $result['messageID'] = $model->getMessageId();
        $result['gateway'] = array();

        if (is_array($model->getGateways())) {
            foreach ($model->getGateways() as $key => $gateway) {
                if ($gateway instanceof GatewayModel) {
                    $result['gateway'][] = array(
                        'gatewayID' => $gateway->getGatewayId(),
                        'gatewayName' => $gateway->getGatewayName(),
                        'gatewayType' => $gateway->getGatewayType(),
                        'bankName' => $gateway->getBankName(),
                        'iconURL' => $gateway->getIconUrl(),
                        'statusDate' => (($gateway->getStatusDate() instanceof DateTime) ?
                            $gateway->getStatusDate()->format(Gateway::DATETIME_FORMAT_LONGER) : ''
                        ),
                    );
                }
            }
        }

        $result['hash'] = $model->getHash();

        return $result;
    }

    /**
     * Transforms XML to model.
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     *
     * @param  SimpleXMLElement $xml
     * @return Model
     */
    public static function toModel(SimpleXMLElement $xml)
    {
        $model = new Model();
        if ($xml->serviceID) {
            $model->setServiceId((string) $xml->serviceID);
        }
        if ($xml->messageID) {
            $model->setMessageId((string) $xml->messageID);
        }
        if (isset($xml->gateway)) {
            if (is_array($xml->gateway) || isset($xml->gateway[0])) {
                foreach ($xml->gateway as $key => $gateway) {
                    $gatewayModel = new GatewayModel();
                    $gatewayModel->setGatewayId((string) $gateway->gatewayID)
                        ->setGatewayName((string) $gateway->gatewayName);
                    if (isset($gateway->gatewayType)) {
                        $gatewayModel->setGatewayType((string) $gateway->gatewayType);
                    }
                    if (isset($gateway->bankName)) {
                        $gatewayModel->setBankName((string) $gateway->bankName);
                    }
                    if (isset($gateway->iconURL)) {
                        $gatewayModel->setIconUrl((string) $gateway->iconURL);
                    }
                    if (isset($gateway->statusDate)) {
                        $gatewayModel->setStatusDate(DateTime::createFromFormat(
                            Gateway::DATETIME_FORMAT_LONGER,
                            (string) $gateway->statusDate,
                            new DateTimeZone(Gateway::DATETIME_TIMEZONE)
                        ));
                    }

                    $model->addGateway($gatewayModel);
                    unset($gatewayModel, $gateway);
                }
            }
        }
        if ($xml->hash) {
            $model->setHash((string) $xml->hash);
        }

        return $model;
    }
}
