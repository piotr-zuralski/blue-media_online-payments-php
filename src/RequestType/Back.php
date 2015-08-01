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
class Back extends AbstractRequestType
{
    const FIELD_SERVICE_ID      = 'ServiceID';
    const FIELD_ORDER_ID        = 'OrderID';
    const FIELD_HASH            = 'Hash';

    protected $fieldsHashOrder = array(
        1 => self::FIELD_SERVICE_ID,
        2 => self::FIELD_ORDER_ID,
    );


} 