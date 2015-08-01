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
class ITN extends AbstractRequestType
{

    const FIELD_SERVICE_ID                          = 'serviceID';
    const FIELD_ORDER_ID                            = 'orderID';
    const FIELD_REMOTE_ID                           = 'remoteID';
    const FIELD_AMOUNT                              = 'amount';
    const FIELD_CURRENCY                            = 'currency';
    const FIELD_GATEWAY_ID                          = 'gatewayID';
    const FIELD_PAYMENT_DATE                        = 'paymentDate';
    const FIELD_PAYMENT_STATUS                      = 'paymentStatus';
    const FIELD_PAYMENT_STATUS_DETAILS              = 'paymentStatusDetails';
    const FIELD_ADDRESS_IP                          = 'addressIP';
    const FIELD_TITLE                               = 'title';
    const FIELD_CUSTOMER_DATA_FNAME                 = 'fName';
    const FIELD_CUSTOMER_DATA_LNAME                 = 'lName';
    const FIELD_CUSTOMER_DATA_STREET_NAME           = 'streetName';
    const FIELD_CUSTOMER_DATA_STREET_HOUSE_NO       = 'streetHouseNo';
    const FIELD_CUSTOMER_DATA_STREET_STAIRCASE_NO   = 'streetStaircaseNo';
    const FIELD_CUSTOMER_DATA_STREET_PREMISE_NO     = 'streetPremiseNo';
    const FIELD_CUSTOMER_DATA_POSTAL_CODE           = 'postalCode';
    const FIELD_CUSTOMER_DATA_CITY                  = 'city';
    const FIELD_CUSTOMER_DATA_NRB                   = 'nrb';
    const FIELD_HASH                                = 'hash';

    protected $fieldsHashOrder = array(
        1 => self::FIELD_SERVICE_ID,
        2 => self::FIELD_ORDER_ID,
        3 => self::FIELD_REMOTE_ID,
        5 => self::FIELD_AMOUNT,
        6 => self::FIELD_CURRENCY,
        7 => self::FIELD_GATEWAY_ID,
        8 => self::FIELD_PAYMENT_DATE,
        9 => self::FIELD_PAYMENT_STATUS,
        10 => self::FIELD_PAYMENT_STATUS_DETAILS,
        20 => self::FIELD_ADDRESS_IP,
        21 => self::FIELD_TITLE,
        22 => self::FIELD_CUSTOMER_DATA_FNAME,
        23 => self::FIELD_CUSTOMER_DATA_LNAME,
        24 => self::FIELD_CUSTOMER_DATA_STREET_NAME,
        25 => self::FIELD_CUSTOMER_DATA_STREET_HOUSE_NO,
        26 => self::FIELD_CUSTOMER_DATA_STREET_STAIRCASE_NO,
        27 => self::FIELD_CUSTOMER_DATA_STREET_PREMISE_NO,
        28 => self::FIELD_CUSTOMER_DATA_POSTAL_CODE,
        29 => self::FIELD_CUSTOMER_DATA_CITY,
        30 => self::FIELD_CUSTOMER_DATA_NRB,
    );

} 