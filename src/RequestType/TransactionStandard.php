<?php

namespace BlueMedia\OnlinePayments\RequestType;


/**
 * (description) 
 *
 * @author    Piotr Żuralski <piotr.zuralski@invicta.pl>
 * @copyright 2015 INVICTA
 * @package   BlueMedia\OnlinePayments\RequestType
 * @since     2015-06-28 
 * @version   Release: $Id$
 */
class TransactionStandard extends AbstractRequestType
{

    const FIELD_SERVICE_ID      = 'ServiceID';
    const FIELD_ORDER_ID        = 'OrderID';
    const FIELD_AMOUNT          = 'Amount';
    const FIELD_DESCRIPTION     = 'Description';
    const FIELD_GATEWAY_ID      = 'GatewayID';
    const FIELD_CURRENCY        = 'Currency';
    const FIELD_CUSTOMER_EMAIL  = 'CustomerEmail';
    const FIELD_CUSTOMER_NRB    = 'CustomerNRB';
    const FIELD_TAX_COUNTRY     = 'TaxCountry';
    const FIELD_CUSTOMER_IP     = 'CustomerIP';
    const FIELD_TITLE           = 'Title';
    const FIELD_RECEIVER_NAME   = 'ReceiverName';
    const FIELD_VALIDITY_TIME   = 'ValidityTime';
    const FIELD_LINK_VALIDITY_TIME  = 'LinkValidityTime';
    const FIELD_HASH                = 'Hash';

    protected $fieldsHashOrder = array(
        1 => self::FIELD_SERVICE_ID,
        2 => self::FIELD_ORDER_ID,
        3 => self::FIELD_AMOUNT,
        4 => self::FIELD_DESCRIPTION,
        5 => self::FIELD_GATEWAY_ID,
        6 => self::FIELD_CURRENCY,
        7 => self::FIELD_CUSTOMER_EMAIL,
        8 => self::FIELD_CUSTOMER_NRB,
        9 => self::FIELD_TAX_COUNTRY,
        10 => self::FIELD_CUSTOMER_IP,
        11 => self::FIELD_TITLE,
        12 => self::FIELD_RECEIVER_NAME,
        20 => self::FIELD_VALIDITY_TIME,
        30 => self::FIELD_LINK_VALIDITY_TIME,
    );

} 