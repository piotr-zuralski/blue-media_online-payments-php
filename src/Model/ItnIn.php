<?php

namespace BlueMedia\OnlinePayments\Model;

use BlueMedia\OnlinePayments\Validator;
use BlueMedia\OnlinePayments\Formatter;
use DomainException;
use DateTime;

/**
 * ITN IN Model
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments\Model
 * @since     2015-08-08
 * @version   2.3.1
 */
class ItnIn extends AbstractModel
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

    const CONFIRMATION_CONFIRMED = 'CONFIRMED';
    const CONFIRMATION_NOT_CONFIRMED = 'NOTCONFIRMED';

    /**
     * Service id
     *
     * @var integer
     */
    protected $serviceId;

    /**
     * Payment order id
     *
     * @var string
     */
    protected $orderId;

    /**
     * Payment remote id
     *
     * @var string
     */
    protected $remoteId;

    /**
     * Payment amount
     *
     * @var float
     */
    protected $amount;

    /**
     * Payment currency
     *
     * @var string
     */
    protected $currency;

    /**
     * Payment gateway id
     *
     * @var integer
     */
    protected $gatewayId;

    /**
     * Payment date
     *
     * @var DateTime
     */
    protected $paymentDate;

    /**
     * Payment status
     *
     * @var string
     */
    protected $paymentStatus;

    /**
     * Payment status details
     *
     * @var string
     */
    protected $paymentStatusDetails;

    /**
     * Customer IP address
     *
     * @var string
     */
    protected $addressIp;

    /**
     * Transaction title
     *
     * @var string
     */
    protected $title;

    /**
     * Customer first name
     *
     * @var string
     */
    protected $customerDatafName;

    /**
     * Customer last name
     *
     * @var string
     */
    protected $customerDatalName;

    /**
     * Customer address - street name
     *
     * @var string
     */
    protected $customerDataStreetName;

    /**
     * Customer address - house number
     *
     * @var string
     */
    protected $customerDataStreetHouseNo;

    /**
     * Customer address - staircase number
     *
     * @var string
     */
    protected $customerDataStreetStaircaseNo;

    /**
     * Customer address - premise number
     *
     * @var string
     */
    protected $customerDataStreetPremiseNo;

    /**
     * Customer address - postal code
     *
     * @var string
     */
    protected $customerDataPostalCode;

    /**
     * Customer address - city
     *
     * @var string
     */
    protected $customerDataCity;

    /**
     * Customer bank account number
     *
     * @var string
     */
    protected $customerDataNrb;

    /**
     * Transaction authorisation date
     *
     * @var DateTime
     */
    protected $transferDate;

    /**
     * Transaction authorisation status
     *
     * @var string
     */
    protected $transferStatus;

    /**
     * Transaction authorisation details
     *
     * @var string
     */
    protected $transferStatusDetails;

    /**
     * Transaction receiver bank
     *
     * @var string
     */
    protected $receiverBank;

    /**
     * Transaction receiver bank account number
     *
     * @var string
     */
    protected $receiverNRB;

    /**
     * Transaction receiver name
     *
     * @var string
     */
    protected $receiverName;

    /**
     * Transaction receiver address
     *
     * @var string
     */
    protected $receiverAddress;

    /**
     * Transaction sender bank
     *
     * @var string
     */
    protected $senderBank;

    /**
     * Transaction sender account bank
     *
     * @var string
     */
    protected $senderNRB;

    /**
     * Hash
     *
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
        return Formatter::formatAmount($this->amount);
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
     * @param DateTime $paymentDate
     *
     * @return $this
     */
    public function setPaymentDate(DateTime $paymentDate)
    {
        $this->paymentDate = $paymentDate;
        return $this;
    }

    /**
     * Return paymentDate
     *
     * @return DateTime
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

    /**
     * Set receiverAddress
     *
     * @param string $receiverAddress
     *
     * @return $this
     */
    public function setReceiverAddress($receiverAddress)
    {
        $this->receiverAddress = (string)$receiverAddress;
        return $this;
    }

    /**
     * Return receiverAddress
     *
     * @return string
     */
    public function getReceiverAddress()
    {
        return $this->receiverAddress;
    }

    /**
     * Set receiverBank
     *
     * @param string $receiverBank
     *
     * @return $this
     */
    public function setReceiverBank($receiverBank)
    {
        $this->receiverBank = (string)$receiverBank;
        return $this;
    }

    /**
     * Return receiverBank
     *
     * @return string
     */
    public function getReceiverBank()
    {
        return $this->receiverBank;
    }

    /**
     * Set receiverNRB
     *
     * @param string $receiverNRB
     *
     * @return $this
     */
    public function setReceiverNRB($receiverNRB)
    {
        $this->receiverNRB = (string)$receiverNRB;
        return $this;
    }

    /**
     * Return receiverNRB
     *
     * @return string
     */
    public function getReceiverNRB()
    {
        return $this->receiverNRB;
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
     * Set senderBank
     *
     * @param string $senderBank
     *
     * @return $this
     */
    public function setSenderBank($senderBank)
    {
        $this->senderBank = (string)$senderBank;
        return $this;
    }

    /**
     * Return senderBank
     *
     * @return string
     */
    public function getSenderBank()
    {
        return $this->senderBank;
    }

    /**
     * Set senderNRB
     *
     * @param string $senderNRB
     *
     * @return $this
     */
    public function setSenderNRB($senderNRB)
    {
        $this->senderNRB = (string)$senderNRB;
        return $this;
    }

    /**
     * Return senderNRB
     *
     * @return string
     */
    public function getSenderNRB()
    {
        return $this->senderNRB;
    }

    /**
     * Set transferDate
     *
     * @param DateTime $transferDate
     *
     * @return $this
     */
    public function setTransferDate(DateTime $transferDate)
    {
        $this->transferDate = $transferDate;
        return $this;
    }

    /**
     * Return transferDate
     *
     * @return DateTime
     */
    public function getTransferDate()
    {
        return $this->transferDate;
    }

    /**
     * Set transferStatus
     *
     * @param string $transferStatus
     *
     * @return $this
     */
    public function setTransferStatus($transferStatus)
    {
        $this->transferStatus = (string)$transferStatus;
        return $this;
    }

    /**
     * Return transferStatus
     *
     * @return string
     */
    public function getTransferStatus()
    {
        return $this->transferStatus;
    }

    /**
     * Set transferStatusDetails
     *
     * @param string $transferStatusDetails
     *
     * @return $this
     */
    public function setTransferStatusDetails($transferStatusDetails)
    {
        $this->transferStatusDetails = (string)$transferStatusDetails;
        return $this;
    }

    /**
     * Return transferStatusDetails
     *
     * @return string
     */
    public function getTransferStatusDetails()
    {
        return $this->transferStatusDetails;
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
        if (empty($this->paymentDate)) {
            throw new DomainException('PaymentDate cannot be empty');
        }
        if (empty($this->paymentStatus)) {
            throw new DomainException('PaymentStatus cannot be empty');
        }
        if (empty($this->hash)) {
            throw new DomainException('Hash cannot be empty');
        }
    }

    public function toArray()
    {
        $result = [];
        $result['serviceID'] = $this->getServiceId();
        $result['orderID'] = $this->getOrderId();
        $result['remoteID'] = $this->getRemoteId();
        $result['amount'] = $this->getAmount();
        $result['currency'] = $this->getCurrency();

        if (!empty($this->getGatewayId())) {
            $result['gatewayID'] = $this->getGatewayId();
        }
        if ($this->getPaymentDate() instanceof DateTime) {
            $result['paymentDate'] = $this->getPaymentDate()->format('YmdHis');
        }
        if (!empty($this->getPaymentStatus())) {
            $result['paymentStatus'] = $this->getPaymentStatus();
        }
        if (!empty($this->getPaymentStatusDetails())) {
            $result['paymentStatusDetails'] = $this->getPaymentStatusDetails();
        }
        $result['Hash'] = $this->getHash();
        return $result;
    }

}