<?php

namespace BlueMedia\OnlinePayments\Model;

/**
 * (description) 
 *
 * @author    Piotr Żuralski <piotr.zuralski@invicta.pl>
 * @copyright 2015 INVICTA
 * @package   BlueMedia\OnlinePayments\Model
 * @since     2015-07-27 
 * @version   Release: $Id$
 */
class TransactionConfirmed extends AbstractModel
{

    protected $serviceId = '';

    protected $orderId = '';

    protected $confirmation = '';

    protected $hash = '';

    public function validate()
    {

    }

} 