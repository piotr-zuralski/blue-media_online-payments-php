<?php

namespace BlueMedia\OnlinePayments\Model;

use BlueMedia\OnlinePayments\Formatter;
use BlueMedia\OnlinePayments\Validator;
use DomainException;

/**
 * (description) 
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments\Model
 * @since     2015-08-08
 * @version   2.3.1
 */
class TransactionCancel extends AbstractModel
{

    /**
     * (description)
     *
     * @required
     * @var integer
     */
    protected $serviceId;

    /**
     * (description)
     *
     * @required
     * @var string
     */
    protected $orderId;

    /**
     * (description)
     *
     * @required
     * @var float
     */
    protected $amount;

    /**
     * (description)
     *
     * @required
     * @var string
     */
    protected $currency;

    /**
     * (description)
     *
     * @var string
     */
    protected $action = 'CANCEL';

    /**
     * (description)
     *
     * @required
     * @var string
     */
    protected $status;

    /**
     * (description)
     *
     * @required
     * @var string
     */
    protected $docHash;

    /**
     * Ustawia action
     *
     * @param string $action
     *
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = (string)$action;
        return $this;
    }

    /**
     * Zwraca action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Ustawia amount
     *
     * @param float $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        Validator::validateAmount($amount);
        $this->amount = (float)$amount;
        return $this;
    }

    /**
     * Zwraca amount
     *
     * @return float
     */
    public function getAmount()
    {
        return Formatter::formatAmount($this->amount);
    }

    /**
     * Ustawia currency
     *
     * @param string $currency
     *
     * @return $this
     */
    public function setCurrency($currency)
    {
        Validator::validateCurrency($currency);
        $this->currency = (string)$currency;
        return $this;
    }

    /**
     * Zwraca currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Ustawia docHash
     *
     * @param string $docHash
     *
     * @return $this
     */
    public function setDocHash($docHash)
    {
        Validator::validateHash($docHash);
        $this->docHash = (string)$docHash;
        return $this;
    }

    /**
     * Zwraca docHash
     *
     * @return string
     */
    public function getDocHash()
    {
        return $this->docHash;
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

    /**
     * Ustawia status
     *
     * @param string $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = (string)$status;
        return $this;
    }

    /**
     * Zwraca status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function validate()
    {
        if (empty($this->serviceId)) {
            throw new DomainException('ServiceId cannot be empty');
        }
        if (empty($this->orderId)) {
            throw new DomainException('OrderId cannot be empty');
        }
        if (empty($this->amount)) {
            throw new DomainException('Amount cannot be empty');
        }
        if (empty($this->currency)) {
            throw new DomainException('Currency cannot be empty');
        }
        if (empty($this->action)) {
            throw new DomainException('Action cannot be empty');
        }
        if (empty($this->docHash)) {
            throw new DomainException('DocHash cannot be empty');
        }
    }

    public function toArray()
    {
        $result = [
            'serviceID' => $this->getServiceId(),
            'orderID' => $this->getOrderId(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'action' => $this->getAction(),
        ];

        if (!empty($this->getStatus())) {
            $result['status'] = $this->getStatus();
        }
        $result['docHash'] = $this->getDocHash();
        return $result;
    }

} 