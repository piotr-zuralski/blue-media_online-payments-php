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
class TransactionBackground extends AbstractRequestType
{

    const FIELD_RECEIVER_NRB    = 'receiverNRB';
    const FIELD_RECEIVER_NAME   = 'receiverName';
    const FIELD_RECEIVER_ADDRESS   = 'receiverAddress';
    const FIELD_ORDER_ID        = 'orderID';
    const FIELD_AMOUNT          = 'amount';
    const FIELD_CURRENCY        = 'currency';
    const FIELD_TITLE           = 'title';
    const FIELD_REMOTE_ID           = 'remoteID';
    const FIELD_BANK_HREF           = 'bankHref';
    const FIELD_HASH            = 'hash';

    const FORM_PAYWAY_BEGIN     = '<!-- PAYWAY FORM BEGIN -->';
    const FORM_PAYWAY_END       = '<!-- PAYWAY FORM END -->';

    protected $fieldsHashOrder = array(
        1 => self::FIELD_RECEIVER_NRB,
        2 => self::FIELD_RECEIVER_NAME,
        3 => self::FIELD_RECEIVER_ADDRESS,
        5 => self::FIELD_ORDER_ID,
        6 => self::FIELD_AMOUNT,
        7 => self::FIELD_CURRENCY,
        8 => self::FIELD_TITLE,
        9 => self::FIELD_REMOTE_ID,
        10 => self::FIELD_BANK_HREF,
    );

} 