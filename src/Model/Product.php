<?php

namespace BlueMedia\OnlinePayments\Model;

use BlueMedia\OnlinePayments\Formatter;
use BlueMedia\OnlinePayments\Validator;

/**
 * Model for ITN IN.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments\Model
 * @since     2015-08-08
 * @version   2.3.3
 */
class Product extends AbstractModel
{

    /**
     * Product amount.
     *
     * @var float
     */
    private $subAmount = 0.0;

    private $params = array();

    /**
     * Set amount.
     *
     * @param float $amount
     *
     * @return $this
     */
    public function setSubAmount($amount)
    {
        $amount = Formatter::formatAmount($amount);
        Validator::validateAmount($amount);
        $this->subAmount = (float) $amount;

        return $this;
    }

    /**
     * Return amount.
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->subAmount;
    }

    public function addParam($name, $value)
    {
        $this->params[] = array('name' => $name, 'value' => $value);

        return $this;
    }

    public function getParams()
    {
        return $this->params;
    }
}
