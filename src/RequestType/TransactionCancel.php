<?php

namespace BlueMedia\OnlinePayments\RequestType;


/**
 * (description) 
 *
 * @author    Piotr Żuralski <piotr.zuralski@invicta.pl>
 * @copyright 2015 INVICTA
 * @package   BlueMedia\OnlinePayments\RequestType
 * @since     2015-07-13 
 * @version   Release: $Id$
 */
class TransactionCancel extends AbstractRequestType
{

    const FIELD_SERVICE_ID      = 'serviceID';
    const FIELD_ORDER_ID        = 'orderID';
    const FIELD_AMOUNT          = 'amount';
    const FIELD_CURRENCY        = 'currency';
    const FIELD_ACTION          = 'action';
    const FIELD_STATUS          = 'status';
    const FIELD_HASH            = 'docHash';

    protected $fieldsHashOrder = array(
        1 => self::FIELD_SERVICE_ID,
        2 => self::FIELD_ORDER_ID,
        3 => self::FIELD_AMOUNT,
        4 => self::FIELD_CURRENCY,
        5 => self::FIELD_ACTION,
        6 => self::FIELD_STATUS,
    );

} 