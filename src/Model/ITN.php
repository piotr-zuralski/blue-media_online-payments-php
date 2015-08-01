<?php

namespace BlueMedia\OnlinePayments\Model;

use BlueMedia\OnlinePayments\Validator;
use DomainException;
use DateTime;

/**
 * ITN Model 
 *
 * @author    Piotr Żuralski <piotr.zuralski@invicta.pl>
 * @copyright 2015 INVICTA
 * @package   BlueMedia\OnlinePayments\Model
 * @since     2015-07-07
 * @version   2.3.1
 */
class ITN extends AbstractModel
{

    const PAYMENT_STATUS_PENDING = 'PENDING';
    const PAYMENT_STATUS_SUCCESS = 'SUCCESS';
    const PAYMENT_STATUS_FAILURE = 'FAILURE';

    const PAYMENT_STATUS_DETAILS_AUTHORIZED = 'AUTHORIZED';
    const PAYMENT_STATUS_DETAILS_ACCEPTED = 'ACCEPTED';
    const PAYMENT_STATUS_DETAILS_INCORRECT_AMOUNT = 'INCORRECT_AMOUNT';
    const PAYMENT_STATUS_DETAILS_EXPIRED = 'EXPIRED';
    const PAYMENT_STATUS_DETAILS_CANCELLED = 'CANCELLED';
    const PAYMENT_STATUS_DETAILS_ANOTHER_ERROR = 'ANOTHER_ERROR';

    /**
     * Service id
     *
     * @hashOrder 1
     * @required
     * @var integer
     */
    protected $serviceId;

    /**
     * Payment order id
     *
     * @hashOrder 2
     * @required
     * @var string
     */
    protected $orderId;

    /**
     * Payment remote id
     *
     * @hashOrder 3
     * @required
     * @var string
     */
    protected $remoteId;

    /**
     * Payment amount
     *
     * @hashOrder 5
     * @required
     * @var float
     */
    protected $amount;

    /**
     * Payment currency
     *
     * @hashOrder 6
     * @required
     * @var string
     */
    protected $currency;

    /**
     * Payment gateway id
     *
     * @hashOrder 7
     * @var integer
     */
    protected $gatewayId;

    /**
     * Payment date
     *
     * @hashOrder 8
     * @var string
     */
    protected $paymentDate;

    /**
     * Payment status
     *
     * @hashOrder 9
     * @var string
     */
    protected $paymentStatus;

    /**
     * Payment status details
     *
     * @hashOrder 10
     * @var string
     */
    protected $paymentStatusDetails;

    /**
     * Customer IP address
     *
     * @hashOrder 20
     * @var string
     */
    protected $addressIp;

    /**
     * Transaction title
     *
     * @hashOrder 21
     * @var string
     */
    protected $title;

    /**
     * Customer first name
     *
     * @hashOrder 22
     * @var string
     */
    protected $customerDatafName;

    /**
     * Customer last name
     *
     * @hashOrder 23
     * @var string
     */
    protected $customerDatalName;

    /**
     * Customer address - street name
     *
     * @hashOrder 24
     * @var string
     */
    protected $customerDataStreetName;

    /**
     * Customer address - house number
     *
     * @hashOrder 25
     * @var string
     */
    protected $customerDataStreetHouseNo;

    /**
     * Customer address - staircase number
     *
     * @hashOrder 26
     * @var string
     */
    protected $customerDataStreetStaircaseNo;

    /**
     * Customer address - premise number
     *
     * @hashOrder 27
     * @var string
     */
    protected $customerDataStreetPremiseNo;

    /**
     * Customer address - postal code
     *
     * @hashOrder 28
     * @var string
     */
    protected $customerDataPostalCode;

    /**
     * Customer address - city
     *
     * @hashOrder 29
     * @var string
     */
    protected $customerDataCity;

    /**
     * Customer bank account number
     *
     * @hashOrder 30
     * @var string
     */
    protected $customerDataNrb;

    /**
     * Transaction authorisation date
     *
     * @hashOrder 40
     * @required
     * @var DateTime
     */
    protected $transferDate;

    /**
     * Transaction authorisation status
     *
     * @hashOrder 41
     * @required
     * @var string
     */
    protected $transferStatus;

    /**
     * Transaction authorisation details
     *
     * @hashOrder 42
     * @var string
     */
    protected $transferStatusDetails;

    /**
     * Hash
     *
     * @required
     * @var string
     */
    protected $hash;

    /**
     * Set addressIp
     *
     * @param string $addressIp
     *
     * @return $this
     */
    public function setAddressIp($addressIp)
    {
        Validator::validateIP($addressIp);
        $this->addressIp = (string)$addressIp;
        return $this;
    }

    /**
     * Return addressIp
     *
     * @return string
     */
    public function getAddressIp()
    {
        return $this->addressIp;
    }

    /**
     * Set amount
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
        $this->currency = (string)$currency;
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
     * Set customerDataCity
     *
     * @param string $customerDataCity
     *
     * @return $this
     */
    public function setCustomerDataCity($customerDataCity)
    {
        $this->customerDataCity = (string)$customerDataCity;
        return $this;
    }

    /**
     * Return customerDataCity
     *
     * @return string
     */
    public function getCustomerDataCity()
    {
        return $this->customerDataCity;
    }

    /**
     * Set customerDataNrb
     *
     * @param string $customerDataNrb
     *
     * @return $this
     */
    public function setCustomerDataNrb($customerDataNrb)
    {
        Validator::validateNrb($customerDataNrb);
        $this->customerDataNrb = (string)$customerDataNrb;
        return $this;
    }

    /**
     * Return customerDataNrb
     *
     * @return string
     */
    public function getCustomerDataNrb()
    {
        return $this->customerDataNrb;
    }

    /**
     * Set customerDataPostalCode
     *
     * @param string $customerDataPostalCode
     *
     * @return $this
     */
    public function setCustomerDataPostalCode($customerDataPostalCode)
    {
        $this->customerDataPostalCode = (string)$customerDataPostalCode;
        return $this;
    }

    /**
     * Return customerDataPostalCode
     *
     * @return string
     */
    public function getCustomerDataPostalCode()
    {
        return $this->customerDataPostalCode;
    }

    /**
     * Set customerDataStreetHouseNo
     *
     * @param string $customerDataStreetHouseNo
     *
     * @return $this
     */
    public function setCustomerDataStreetHouseNo($customerDataStreetHouseNo)
    {
        $this->customerDataStreetHouseNo = (string)$customerDataStreetHouseNo;
        return $this;
    }

    /**
     * Return customerDataStreetHouseNo
     *
     * @return string
     */
    public function getCustomerDataStreetHouseNo()
    {
        return $this->customerDataStreetHouseNo;
    }

    /**
     * Set customerDataStreetName
     *
     * @param string $customerDataStreetName
     *
     * @return $this
     */
    public function setCustomerDataStreetName($customerDataStreetName)
    {
        $this->customerDataStreetName = (string)$customerDataStreetName;
        return $this;
    }

    /**
     * Return customerDataStreetName
     *
     * @return string
     */
    public function getCustomerDataStreetName()
    {
        return $this->customerDataStreetName;
    }

    /**
     * Set customerDataStreetPremiseNo
     *
     * @param string $customerDataStreetPremiseNo
     *
     * @return $this
     */
    public function setCustomerDataStreetPremiseNo($customerDataStreetPremiseNo)
    {
        $this->customerDataStreetPremiseNo = (string)$customerDataStreetPremiseNo;
        return $this;
    }

    /**
     * Return customerDataStreetPremiseNo
     *
     * @return string
     */
    public function getCustomerDataStreetPremiseNo()
    {
        return $this->customerDataStreetPremiseNo;
    }

    /**
     * Set customerDataStreetStaircaseNo
     *
     * @param string $customerDataStreetStaircaseNo
     *
     * @return $this
     */
    public function setCustomerDataStreetStaircaseNo($customerDataStreetStaircaseNo)
    {
        $this->customerDataStreetStaircaseNo = (string)$customerDataStreetStaircaseNo;
        return $this;
    }

    /**
     * Return customerDataStreetStaircaseNo
     *
     * @return string
     */
    public function getCustomerDataStreetStaircaseNo()
    {
        return $this->customerDataStreetStaircaseNo;
    }

    /**
     * Set customerDatafName
     *
     * @param string $customerDatafName
     *
     * @return $this
     */
    public function setCustomerDatafName($customerDatafName)
    {
        $this->customerDatafName = (string)$customerDatafName;
        return $this;
    }

    /**
     * Return customerDatafName
     *
     * @return string
     */
    public function getCustomerDatafName()
    {
        return $this->customerDatafName;
    }

    /**
     * Set customerDatalName
     *
     * @param string $customerDatalName
     *
     * @return $this
     */
    public function setCustomerDatalName($customerDatalName)
    {
        $this->customerDatalName = (string)$customerDatalName;
        return $this;
    }

    /**
     * Return customerDatalName
     *
     * @return string
     */
    public function getCustomerDatalName()
    {
        return $this->customerDatalName;
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
     * Set paymentDate
     *
     * @param string $paymentDate
     *
     * @return $this
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = (string)$paymentDate;
        return $this;
    }

    /**
     * Return paymentDate
     *
     * @return string
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * Set paymentStatus
     *
     * @param string $paymentStatus
     *
     * @return $this
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = (string)$paymentStatus;
        return $this;
    }

    /**
     * Return paymentStatus
     *
     * @return string
     */
    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    /**
     * Set paymentStatusDetails
     *
     * @param string $paymentStatusDetails
     *
     * @return $this
     */
    public function setPaymentStatusDetails($paymentStatusDetails)
    {
        $this->paymentStatusDetails = (string)$paymentStatusDetails;
        return $this;
    }

    /**
     * Return paymentStatusDetails
     *
     * @return string
     */
    public function getPaymentStatusDetails()
    {
        return $this->paymentStatusDetails;
    }

    /**
     * Set remoteId
     *
     * @param string $remoteId
     *
     * @return $this
     */
    public function setRemoteId($remoteId)
    {
        $this->remoteId = (string)$remoteId;
        return $this;
    }

    /**
     * Return remoteId
     *
     * @return string
     */
    public function getRemoteId()
    {
        return $this->remoteId;
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
            throw new DomainException('ReceiverNrb cannot be empty');
        }
        if (empty($this->orderId)) {
            throw new DomainException('OrderId cannot be empty');
        }
        if (empty($this->remoteId)) {
            throw new DomainException('RemoteId cannot be empty');
        }
        if (empty($this->amount)) {
            throw new DomainException('Amount cannot be empty');
        }
        if (empty($this->currency)) {
            throw new DomainException('Currency cannot be empty');
        }
        if (empty($this->hash)) {
            throw new DomainException('Hash cannot be empty');
        }
    }

}