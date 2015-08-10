<?php

namespace BlueMedia\OnlinePayments\Model;

/**
 * (description) 
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments\Model
 * @since     2015-08-08
 * @version   2.3.1
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