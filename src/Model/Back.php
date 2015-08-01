<?php

namespace BlueMedia\OnlinePayments\Model;

use BlueMedia\OnlinePayments\Validator;
use DomainException;

/**
 * (description) 
 *
 * @author    Piotr Żuralski <piotr.zuralski@invicta.pl>
 * @copyright 2015 INVICTA
 * @package   BlueMedia\OnlinePayments\Model
 * @since     2015-07-07 
 * @version   Release: $Id$
 */
class Back extends AbstractModel
{

    /**
     * Service Id
     *
     * @required
     * @var integer
     */
    protected $serviceId;

    /**
     * Order id
     *
     * @required
     * @var string
     */
    protected $orderId;

    /**
     * Hash
     *
     * @required
     * @var string
     */
    protected $hash;

    /**
     * Ustawia hash
     *
     * @param string $hash
     *
     * @return $this
     */
    public function setHash($hash)
    {
        Validator::validateHash($hash);
        $this->hash = (string)$hash;
        return $this;
    }

    /**
     * Zwraca hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Ustawia orderId
     *
     * @param string $orderId
     *
     * @return $this
     */
    public function setOrderId($orderId)
    {
        Validator::validateOrderId($orderId);
        $this->orderId = (string)$orderId;
        return $this;
    }

    /**
     * Zwraca orderId
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Ustawia serviceId
     *
     * @param int $serviceId
     *
     * @return $this
     */
    public function setServiceId($serviceId)
    {
        Validator::validateServiceId($serviceId);
        $this->serviceId = (int)$serviceId;
        return $this;
    }

    /**
     * Zwraca serviceId
     *
     * @return int
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    public function validate()
    {
        if (empty($this->serviceId)) {
            throw new DomainException('ReceiverNrb cannot be empty');
        }
        if (empty($this->orderId)) {
            throw new DomainException('OrderId cannot be empty');
        }
        if (empty($this->hash)) {
            throw new DomainException('Hash cannot be empty');
        }
    }

}