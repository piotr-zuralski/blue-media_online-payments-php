<?php

namespace BlueMedia\OnlinePayments\Model;

use BlueMedia\OnlinePayments\Formatter;
use BlueMedia\OnlinePayments\Validator;
use DomainException;
use DateTime;

/**
 * (description) 
 *
 * @author    Piotr Żuralski <piotr.zuralski@invicta.pl>
 * @copyright 2015 INVICTA
 * @package   BlueMedia\OnlinePayments\Model
 * @since     2015-07-07 
 * @version   Release: $Id$
 */
class TransactionStandard extends AbstractModel
{

    /**
     * Service id
     *
     * @hashOrder 1
     * @required
     * @var integer
     */
    protected $serviceId;

    /**
     * Transaction order id
     *
     * @hashOrder 2
     * @required
     * @var string
     */
    protected $orderId;

    /**
     * Transaction amount
     *
     * @hashOrder 3
     * @required
     * @var float
     */
    protected $amount;

    /**
     * Transaction description
     *
     * @hashOrder 4
     * @var string
     */
    protected $description;

    /**
     * Transaction gateway id
     *
     * @hashOrder 5
     * @var integer
     */
    protected $gatewayId;

    /**
     * Transaction currency
     *
     * @hashOrder 6
     * @var string
     */
    protected $currency;

    /**
     * Transaction customer e-mail address
     *
     * @hashOrder 7
     * @var string
     */
    protected $customerEmail;

    /**
     * Transaction customer bank account number
     *
     * @hashOrder 8
     * @var string
     */
    protected $customerNrb;

    /**
     * Transaction tax country
     *
     * @hashOrder 9
     * @var string
     */
    protected $taxCountry;

    /**
     * Customer IP address
     *
     * @hashOrder 10
     * @var string
     */
    protected $customerIp;

    /**
     * Transaction title
     *
     * @hashOrder 11
     * @var string
     */
    protected $title;

    /**
     * Transaction receiver name
     *
     * @hashOrder 12
     * @var string
     */
    protected $receiverName;

    /**
     * Transaction validity time
     *
     * @hashOrder 20
     * @var DateTime
     */
    protected $validityTime;

    /**
     * Transaction link validity time
     *
     * @hashOrder 30
     * @var DateTime
     */
    protected $linkValidityTime;

    /**
     * Hash
     *
     * @required
     * @var string
     */
    protected $hash;

    /**
     * Set amount
     *
     * @param float $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        $amount = Formatter::formatAmount($amount);
        Validator::validateAmount($amount);
        $this->amount = (float)$amount;
        return $this;
    }

    /**
     * Return amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return $this
     */
    public function setCurrency($currency)
    {
        Validator::validateCurrency($currency);
        $this->currency = (string)mb_strtoupper($currency);
        return $this;
    }

    /**
     * Return currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set customerEmail
     *
     * @param string $customerEmail
     *
     * @return $this
     */
    public function setCustomerEmail($customerEmail)
    {
        Validator::validateEmail($customerEmail);
        $this->customerEmail = (string)mb_strtolower($customerEmail);
        return $this;
    }

    /**
     * Return customerEmail
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * Set customerIp
     *
     * @param string $customerIp
     *
     * @return $this
     */
    public function setCustomerIp($customerIp)
    {
        Validator::validateIP($customerIp);
        $this->customerIp = (string)$customerIp;
        return $this;
    }

    /**
     * Return customerIp
     *
     * @return string
     */
    public function getCustomerIp()
    {
        return $this->customerIp;
    }

    /**
     * Set customerNrb
     *
     * @param string $customerNrb
     *
     * @return $this
     */
    public function setCustomerNrb($customerNrb)
    {
        Validator::validateNrb($customerNrb);
        $this->customerNrb = (string)$customerNrb;
        return $this;
    }

    /**
     * Return customerNrb
     *
     * @return string
     */
    public function getCustomerNrb()
    {
        return $this->customerNrb;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $description = Formatter::formatDescription($description);
        Validator::validateDescription($description);
        $this->description = (string)$description;
        return $this;
    }

    /**
     * Return description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set gatewayId
     *
     * @param int $gatewayId
     *
     * @return $this
     */
    public function setGatewayId($gatewayId)
    {
        Validator::validateGatewayId($gatewayId);
        $this->gatewayId = (int)$gatewayId;
        return $this;
    }

    /**
     * Return gatewayId
     *
     * @return int
     */
    public function getGatewayId()
    {
        return $this->gatewayId;
    }

    /**
     * Set hash
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
     * Return hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set orderId
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
     * Return orderId
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set receiverName
     *
     * @param string $receiverName
     *
     * @return $this
     */
    public function setReceiverName($receiverName)
    {
        Validator::validateReceiverName($receiverName);
        $this->receiverName = (string)$receiverName;
        return $this;
    }

    /**
     * Return receiverName
     *
     * @return string
     */
    public function getReceiverName()
    {
        return $this->receiverName;
    }

    /**
     * Set serviceId
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
     * Return serviceId
     *
     * @return int
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
     * Set taxCountry
     *
     * @param string $taxCountry
     *
     * @return $this
     */
    public function setTaxCountry($taxCountry)
    {
        Validator::validateTaxCountry($taxCountry);
        $this->taxCountry = (string)$taxCountry;
        return $this;
    }

    /**
     * Return taxCountry
     *
     * @return string
     */
    public function getTaxCountry()
    {
        return $this->taxCountry;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        Validator::validateTitle($title);
        $this->title = (string)$title;
        return $this;
    }

    /**
     * Return title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
        if (empty($this->hash)) {
            throw new DomainException('Hash cannot be empty');
        }
    }

} 