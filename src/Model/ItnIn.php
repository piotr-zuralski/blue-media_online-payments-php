<?php

namespace BlueMedia\OnlinePayments\Model;

use BlueMedia\OnlinePayments\Action\ITN\Transformer;
use BlueMedia\OnlinePayments\Formatter;
use BlueMedia\OnlinePayments\Validator;
use DateTime;
use DomainException;

/**
 * Model for ITN IN.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments\Model
 * @since     2015-08-08
 * @version   2.3.3
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
    const PAYMENT_STATUS_DETAILS_CONFIRMED = 'CONFIRMED';
    const PAYMENT_STATUS_DETAILS_CANCELLED = 'CANCELLED';
    const PAYMENT_STATUS_DETAILS_ANOTHER_ERROR = 'ANOTHER_ERROR';
    const PAYMENT_STATUS_DETAILS_REJECTED = 'REJECTED';
    const PAYMENT_STATUS_DETAILS_REJECTED_BY_USER = 'REJECTED_BY_USER';

    const CONFIRMATION_CONFIRMED = 'CONFIRMED';
    const CONFIRMATION_NOT_CONFIRMED = 'NOTCONFIRMED';

    const VERIFICATION_STATUS_PENDING = 'PENDING';
    const VERIFICATION_STATUS_POSITIVE = 'POSITIVE';
    const VERIFICATION_STATUS_NEGATIVE = 'NEGATIVE';

    const VERIFICATION_STATUS_REASON_NAME = 'NAME';
    const VERIFICATION_STATUS_REASON_NRB = 'NRB';
    const VERIFICATION_STATUS_REASON_TITLE = 'TITLE';
    const VERIFICATION_STATUS_REASON_STREET = 'STREET';
    const VERIFICATION_STATUS_REASON_HOUSE_NUMBER = 'HOUSE_NUMBER';
    const VERIFICATION_STATUS_REASON_STAIRCASE = 'STAIRCASE';
    const VERIFICATION_STATUS_REASON_PREMISE_NUMBER = 'PREMISE_NUMBER';
    const VERIFICATION_STATUS_REASON_POSTAL_CODE = 'POSTAL_CODE';
    const VERIFICATION_STATUS_REASON_CITY = 'CITY';
    const VERIFICATION_STATUS_REASON_BLACKLISTED = 'BLACKLISTED';
    const VERIFICATION_STATUS_REASON_SHOP_FORMAL_REQUIREMENTS = 'SHOP_FORMAL_REQUIREMENTS';
    const VERIFICATION_STATUS_REASON_NEED_FEEDBACK = 'NEED_FEEDBACK';

    const CARD_DATA_ISSUER_VISA = 'VISA';
    const CARD_DATA_ISSUER_MASTERCARD = 'MASTERCARD';
    const CARD_DATA_ISSUER_MAESTRO = 'MAESTRO';
    const CARD_DATA_ISSUER_AMERICAN_EXPRESS = 'AMERICAN EXPRESS';
    const CARD_DATA_ISSUER_DISCOVER = 'DISCOVER';
    const CARD_DATA_ISSUER_DINERS = 'DINERS';

    /**
     * Service id.
     *
     * @type int
     */
    protected $serviceId;

    /**
     * Payment order id.
     *
     * @type string
     */
    protected $orderId;

    /**
     * Payment remote id.
     *
     * @type string
     */
    protected $remoteId;

    /**
     * Payment amount.
     *
     * @type float
     */
    protected $amount;

    /**
     * Payment currency.
     *
     * @type string
     */
    protected $currency;

    /**
     * Payment gateway id.
     *
     * @type int
     */
    protected $gatewayId;

    /**
     * Payment date.
     *
     * @type DateTime
     */
    protected $paymentDate;

    /**
     * Payment status.
     *
     * @type string
     */
    protected $paymentStatus;

    /**
     * Payment status details.
     *
     * @type string
     */
    protected $paymentStatusDetails;

    /**
     * Customer IP address.
     *
     * @type string
     */
    protected $addressIp;

    /**
     * Tytuł wpłaty
     *
     * @type string
     */
    protected $title;

    /**
     * Imię płatnika
     *
     * @type string
     */
    protected $customerDatafName;

    /**
     * Nazwisko płatnika
     *
     * @type string
     */
    protected $customerDatalName;

    /**
     * Nazwa ulicy płatnika
     *
     * @type string
     */
    protected $customerDataStreetName;

    /**
     * Numer domu płatnika
     *
     * @type string
     */
    protected $customerDataStreetHouseNo;

    /**
     * Numer klatki płatnika
     *
     * @type string
     */
    protected $customerDataStreetStaircaseNo;

    /**
     * Numer lokalu płatnika
     *
     * @type string
     */
    protected $customerDataStreetPremiseNo;

    /**
     * Kod pocztowy adresu płatnika
     *
     * @type string
     */
    protected $customerDataPostalCode;

    /**
     * Customer address - city.
     *
     * @type string
     */
    protected $customerDataCity;

    /**
     * Customer bank account number.
     *
     * @type string
     */
    protected $customerDataNrb;

    /**
     * Transaction authorisation date.
     *
     * @type DateTime
     */
    protected $transferDate;

    /**
     * Transaction authorisation status.
     *
     * @type string
     */
    protected $transferStatus;

    /**
     * Transaction authorisation details.
     *
     * @type string
     */
    protected $transferStatusDetails;

    /**
     * Transaction receiver bank.
     *
     * @type string
     */
    protected $receiverBank;

    /**
     * Transaction receiver bank account number.
     *
     * @type string
     */
    protected $receiverNRB;

    /**
     * Transaction receiver name.
     *
     * @type string
     */
    protected $receiverName;

    /**
     * Transaction receiver address.
     *
     * @type string
     */
    protected $receiverAddress;

    /**
     * Transaction sender bank.
     *
     * @type string
     */
    protected $senderBank;

    /**
     * Transaction sender account bank.
     *
     * @type string
     */
    protected $senderNRB;

    /**
     * Hash.
     *
     * @type string
     */
    protected $hash;

    /**
     * Payment remote out id.
     *
     * @type string
     */
    protected $remoteOutID;

    /**
     * Numer dokumentu finansowego w Serwisie
     *
     * @var string
     */
    protected $invoiceNumber;

    /**
     * Numer Klienta w Serwisie
     *
     * @var string
     */
    protected $customerNumber;

    /**
     * Adres email Klienta
     *
     * @var string
     */
    protected $customerEmail;

    /**
     * Numer telefonu Klienta
     *
     * @var string
     */
    protected $customerPhone;

    /**
     * Dane płatnika w postaci niepodzielonej
     *
     * @var string
     */
    protected $customerDataSenderData;

    /**
     * Status weryfikacji płatnika
     *
     * @var string
     */
    protected $verificationStatus;

    /**
     * Lista zawierająca powody negatywnej, lub oczekującej weryfikacji
     *
     * @var array
     */
    protected $verificationStatusReasons;

    /**
     * Kwota początkowa transakcji
     *
     * @var float
     */
    protected $startAmount;

    /**
     * Akcja w procesie płatności automatycznej
     *
     * @var string
     */
    protected $recurringDataRecurringAction;

    /**
     * Identyfikator płatności automatycznej generowany przez BM
     *
     * @var string
     */
    protected $recurringDataClientHash;

    /**
     * Index karty
     *
     * @var string
     */
    protected $cardDataIndex;

    /**
     * Ważność karty w formacie YYYY
     *
     * @var integer
     */
    protected $cardDataValidityYear;

    /**
     * Ważność karty w formacie mm
     *
     * @var integer
     */
    protected $cardDataValidityMonth;

    /**
     * Typ karty
     *
     * @var string
     */
    protected $cardDataIssuer;

    /**
     * Pierwsze 6 cyfr numeru karty
     *
     * @var integer
     */
    protected $cardDataBin;

    /**
     * Ostatnie 4 cyfry numeru karty
     *
     * @var integer
     */
    protected $cardDataMask;

    /**
     * Ustawia addressIp.
     *
     * @param string $addressIp
     *
     * @return $this
     */
    public function setAddressIp($addressIp)
    {
        Validator::validateIP($addressIp);
        $this->addressIp = (string) $addressIp;

        return $this;
    }

    /**
     * Zwraca addressIp.
     *
     * @return string
     */
    public function getAddressIp()
    {
        return $this->addressIp;
    }

    /**
     * Ustawia amount.
     *
     * @param float $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        Validator::validateAmount($amount);
        $this->amount = (float) $amount;

        return $this;
    }

    /**
     * Zwraca amount.
     *
     * @return float
     */
    public function getAmount()
    {
        return Formatter::formatAmount($this->amount);
    }

    /**
     * Ustawia currency.
     *
     * @param string $currency
     *
     * @return $this
     */
    public function setCurrency($currency)
    {
        Validator::validateCurrency($currency);
        $this->currency = (string) $currency;

        return $this;
    }

    /**
     * Zwraca currency.
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Ustawia customerDataCity.
     *
     * @param string $customerDataCity
     *
     * @return $this
     */
    public function setCustomerDataCity($customerDataCity)
    {
        $this->customerDataCity = (string) $customerDataCity;

        return $this;
    }

    /**
     * Zwraca customerDataCity.
     *
     * @return string
     */
    public function getCustomerDataCity()
    {
        return $this->customerDataCity;
    }

    /**
     * Ustawia customerDataNrb.
     *
     * @param string $customerDataNrb
     *
     * @return $this
     */
    public function setCustomerDataNrb($customerDataNrb)
    {
        Validator::validateNrb($customerDataNrb);
        $this->customerDataNrb = (string) $customerDataNrb;

        return $this;
    }

    /**
     * Zwraca customerDataNrb.
     *
     * @return string
     */
    public function getCustomerDataNrb()
    {
        return $this->customerDataNrb;
    }

    /**
     * Ustawia customerDataPostalCode.
     *
     * @param string $customerDataPostalCode
     *
     * @return $this
     */
    public function setCustomerDataPostalCode($customerDataPostalCode)
    {
        $this->customerDataPostalCode = (string) $customerDataPostalCode;

        return $this;
    }

    /**
     * Zwraca customerDataPostalCode.
     *
     * @return string
     */
    public function getCustomerDataPostalCode()
    {
        return $this->customerDataPostalCode;
    }

    /**
     * Ustawia customerDataStreetHouseNo.
     *
     * @param string $customerDataStreetHouseNo
     *
     * @return $this
     */
    public function setCustomerDataStreetHouseNo($customerDataStreetHouseNo)
    {
        $this->customerDataStreetHouseNo = (string) $customerDataStreetHouseNo;

        return $this;
    }

    /**
     * Zwraca customerDataStreetHouseNo.
     *
     * @return string
     */
    public function getCustomerDataStreetHouseNo()
    {
        return $this->customerDataStreetHouseNo;
    }

    /**
     * Ustawia customerDataStreetName.
     *
     * @param string $customerDataStreetName
     *
     * @return $this
     */
    public function setCustomerDataStreetName($customerDataStreetName)
    {
        $this->customerDataStreetName = (string) $customerDataStreetName;

        return $this;
    }

    /**
     * Zwraca customerDataStreetName.
     *
     * @return string
     */
    public function getCustomerDataStreetName()
    {
        return $this->customerDataStreetName;
    }

    /**
     * Ustawia customerDataStreetPremiseNo.
     *
     * @param string $customerDataStreetPremiseNo
     *
     * @return $this
     */
    public function setCustomerDataStreetPremiseNo($customerDataStreetPremiseNo)
    {
        $this->customerDataStreetPremiseNo = (string) $customerDataStreetPremiseNo;

        return $this;
    }

    /**
     * Zwraca customerDataStreetPremiseNo.
     *
     * @return string
     */
    public function getCustomerDataStreetPremiseNo()
    {
        return $this->customerDataStreetPremiseNo;
    }

    /**
     * Ustawia customerDataStreetStaircaseNo.
     *
     * @param string $customerDataStreetStaircaseNo
     *
     * @return $this
     */
    public function setCustomerDataStreetStaircaseNo($customerDataStreetStaircaseNo)
    {
        $this->customerDataStreetStaircaseNo = (string) $customerDataStreetStaircaseNo;

        return $this;
    }

    /**
     * Zwraca customerDataStreetStaircaseNo.
     *
     * @return string
     */
    public function getCustomerDataStreetStaircaseNo()
    {
        return $this->customerDataStreetStaircaseNo;
    }

    /**
     * Ustawia customerDatafName.
     *
     * @param string $customerDatafName
     *
     * @return $this
     */
    public function setCustomerDatafName($customerDatafName)
    {
        $this->customerDatafName = (string) $customerDatafName;

        return $this;
    }

    /**
     * Zwraca customerDatafName.
     *
     * @return string
     */
    public function getCustomerDatafName()
    {
        return $this->customerDatafName;
    }

    /**
     * Ustawia customerDatalName.
     *
     * @param string $customerDatalName
     *
     * @return $this
     */
    public function setCustomerDatalName($customerDatalName)
    {
        $this->customerDatalName = (string) $customerDatalName;

        return $this;
    }

    /**
     * Zwraca customerDatalName.
     *
     * @return string
     */
    public function getCustomerDatalName()
    {
        return $this->customerDatalName;
    }

    /**
     * Ustawia gatewayId.
     *
     * @param int $gatewayId
     *
     * @return $this
     */
    public function setGatewayId($gatewayId)
    {
        Validator::validateGatewayId($gatewayId);
        $this->gatewayId = (int) $gatewayId;

        return $this;
    }

    /**
     * Zwraca gatewayId.
     *
     * @return int
     */
    public function getGatewayId()
    {
        return $this->gatewayId;
    }

    /**
     * Ustawia hash.
     *
     * @param string $hash
     *
     * @return $this
     */
    public function setHash($hash)
    {
        Validator::validateHash($hash);
        $this->hash = (string) $hash;

        return $this;
    }

    /**
     * Zwraca hash.
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Ustawia orderId.
     *
     * @param string $orderId
     *
     * @return $this
     */
    public function setOrderId($orderId)
    {
        Validator::validateOrderId($orderId);
        $this->orderId = (string) $orderId;

        return $this;
    }

    /**
     * Zwraca orderId.
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Ustawia paymentDate.
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
     * Zwraca paymentDate.
     *
     * @return DateTime
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * Ustawia paymentStatus.
     *
     * @param string $paymentStatus
     *
     * @return $this
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = (string) $paymentStatus;

        return $this;
    }

    /**
     * Zwraca paymentStatus.
     *
     * @return string
     */
    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    /**
     * Ustawia paymentStatusDetails.
     *
     * @param string $paymentStatusDetails
     *
     * @return $this
     */
    public function setPaymentStatusDetails($paymentStatusDetails)
    {
        $this->paymentStatusDetails = (string) $paymentStatusDetails;

        return $this;
    }

    /**
     * Zwraca paymentStatusDetails.
     *
     * @return string
     */
    public function getPaymentStatusDetails()
    {
        return $this->paymentStatusDetails;
    }

    /**
     * Ustawia remoteId.
     *
     * @param string $remoteId
     *
     * @return $this
     */
    public function setRemoteId($remoteId)
    {
        $this->remoteId = (string) $remoteId;

        return $this;
    }

    /**
     * Zwraca remoteId.
     *
     * @return string
     */
    public function getRemoteId()
    {
        return $this->remoteId;
    }

    /**
     * Ustawia serviceId.
     *
     * @param int $serviceId
     *
     * @return $this
     */
    public function setServiceId($serviceId)
    {
        Validator::validateServiceId($serviceId);
        $this->serviceId = (int) $serviceId;

        return $this;
    }

    /**
     * Zwraca serviceId.
     *
     * @return int
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
     * Ustawia tytuł wpłaty
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        Validator::validateTitle($title);
        $this->title = (string) $title;

        return $this;
    }

    /**
     * Zwraca tytuł wpłaty
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Ustawia receiverAddress.
     *
     * @param string $receiverAddress
     *
     * @return $this
     */
    public function setReceiverAddress($receiverAddress)
    {
        $this->receiverAddress = (string) $receiverAddress;

        return $this;
    }

    /**
     * Zwraca receiverAddress.
     *
     * @return string
     */
    public function getReceiverAddress()
    {
        return $this->receiverAddress;
    }

    /**
     * Ustawia receiverBank.
     *
     * @param string $receiverBank
     *
     * @return $this
     */
    public function setReceiverBank($receiverBank)
    {
        $this->receiverBank = (string) $receiverBank;

        return $this;
    }

    /**
     * Zwraca receiverBank.
     *
     * @return string
     */
    public function getReceiverBank()
    {
        return $this->receiverBank;
    }

    /**
     * Ustawia receiverNRB.
     *
     * @param string $receiverNRB
     *
     * @return $this
     */
    public function setReceiverNRB($receiverNRB)
    {
        $this->receiverNRB = (string) $receiverNRB;

        return $this;
    }

    /**
     * Zwraca receiverNRB.
     *
     * @return string
     */
    public function getReceiverNRB()
    {
        return $this->receiverNRB;
    }

    /**
     * Ustawia receiverName.
     *
     * @param string $receiverName
     *
     * @return $this
     */
    public function setReceiverName($receiverName)
    {
        $this->receiverName = (string) $receiverName;

        return $this;
    }

    /**
     * Zwraca receiverName.
     *
     * @return string
     */
    public function getReceiverName()
    {
        return $this->receiverName;
    }

    /**
     * Ustawia senderBank.
     *
     * @param string $senderBank
     *
     * @return $this
     */
    public function setSenderBank($senderBank)
    {
        $this->senderBank = (string) $senderBank;

        return $this;
    }

    /**
     * Zwraca senderBank.
     *
     * @return string
     */
    public function getSenderBank()
    {
        return $this->senderBank;
    }

    /**
     * Ustawia senderNRB.
     *
     * @param string $senderNRB
     *
     * @return $this
     */
    public function setSenderNRB($senderNRB)
    {
        $this->senderNRB = (string) $senderNRB;

        return $this;
    }

    /**
     * Zwraca senderNRB.
     *
     * @return string
     */
    public function getSenderNRB()
    {
        return $this->senderNRB;
    }

    /**
     * Ustawia transferDate.
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
     * Zwraca transferDate.
     *
     * @return DateTime
     */
    public function getTransferDate()
    {
        return $this->transferDate;
    }

    /**
     * Ustawia transferStatus.
     *
     * @param string $transferStatus
     *
     * @return $this
     */
    public function setTransferStatus($transferStatus)
    {
        $this->transferStatus = (string) $transferStatus;

        return $this;
    }

    /**
     * Zwraca transferStatus.
     *
     * @return string
     */
    public function getTransferStatus()
    {
        return $this->transferStatus;
    }

    /**
     * Ustawia transferStatusDetails.
     *
     * @param string $transferStatusDetails
     *
     * @return $this
     */
    public function setTransferStatusDetails($transferStatusDetails)
    {
        $this->transferStatusDetails = (string) $transferStatusDetails;

        return $this;
    }

    /**
     * Zwraca transferStatusDetails.
     *
     * @return string
     */
    public function getTransferStatusDetails()
    {
        return $this->transferStatusDetails;
    }

    /**
     * @return string
     */
    public function getRemoteOutID()
    {
        return $this->remoteOutID;
    }

    /**
     * @param string $remoteOutID
     */
    public function setRemoteOutID($remoteOutID)
    {
        $this->remoteOutID = $remoteOutID;
    }

    /**
     * @return string
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * @param string $invoiceNumber
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;
    }

    /**
     * @return string
     */
    public function getCustomerNumber()
    {
        return $this->customerNumber;
    }

    /**
     * @param string $customerNumber
     */
    public function setCustomerNumber($customerNumber)
    {
        $this->customerNumber = $customerNumber;
    }

    /**
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * @param string $customerEmail
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;
    }

    /**
     * @return string
     */
    public function getCustomerPhone()
    {
        return $this->customerPhone;
    }

    /**
     * @param string $customerPhone
     */
    public function setCustomerPhone($customerPhone)
    {
        $this->customerPhone = $customerPhone;
    }

    /**
     * @return string
     */
    public function getCustomerDataSenderData()
    {
        return $this->customerDataSenderData;
    }

    /**
     * @param string $customerDataSenderData
     */
    public function setCustomerDataSenderData($customerDataSenderData)
    {
        $this->customerDataSenderData = $customerDataSenderData;
    }

    /**
     * @return string
     */
    public function getVerificationStatus()
    {
        return $this->verificationStatus;
    }

    /**
     * @param string $verificationStatus
     */
    public function setVerificationStatus($verificationStatus)
    {
        $this->verificationStatus = $verificationStatus;
    }

    /**
     * @return array
     */
    public function getVerificationStatusReasons()
    {
        return $this->verificationStatusReasons;
    }

    /**
     * @param array $verificationStatusReasons
     */
    public function setVerificationStatusReasons($verificationStatusReasons)
    {
        $this->verificationStatusReasons = $verificationStatusReasons;
    }

    /**
     * Zwraca kwotę początkową transakcji
     *
     * @return float
     */
    public function getStartAmount()
    {
        return $this->startAmount;
    }

    /**
     * Ustawia kwotę początkową transakcji
     *
     * @param float $startAmount
     */
    public function setStartAmount($startAmount)
    {
        $this->startAmount = $startAmount;
    }

    /**
     * @return string
     */
    public function getRecurringDataRecurringAction()
    {
        return $this->recurringDataRecurringAction;
    }

    /**
     * @param string $recurringDataRecurringAction
     */
    public function setRecurringDataRecurringAction($recurringDataRecurringAction)
    {
        $this->recurringDataRecurringAction = $recurringDataRecurringAction;
    }

    /**
     * @return string
     */
    public function getRecurringDataClientHash()
    {
        return $this->recurringDataClientHash;
    }

    /**
     * @param string $recurringDataClientHash
     */
    public function setRecurringDataClientHash($recurringDataClientHash)
    {
        $this->recurringDataClientHash = $recurringDataClientHash;
    }

    /**
     * @return string
     */
    public function getCardDataIndex()
    {
        return $this->cardDataIndex;
    }

    /**
     * @param string $cardDataIndex
     */
    public function setCardDataIndex($cardDataIndex)
    {
        $this->cardDataIndex = $cardDataIndex;
    }

    /**
     * @return int
     */
    public function getCardDataValidityYear()
    {
        return $this->cardDataValidityYear;
    }

    /**
     * @param int $cardDataValidityYear
     */
    public function setCardDataValidityYear($cardDataValidityYear)
    {
        $this->cardDataValidityYear = $cardDataValidityYear;
    }

    /**
     * @return int
     */
    public function getCardDataValidityMonth()
    {
        return $this->cardDataValidityMonth;
    }

    /**
     * @param int $cardDataValidityMonth
     */
    public function setCardDataValidityMonth($cardDataValidityMonth)
    {
        $this->cardDataValidityMonth = $cardDataValidityMonth;
    }

    /**
     * @return string
     */
    public function getCardDataIssuer()
    {
        return $this->cardDataIssuer;
    }

    /**
     * @param string $cardDataIssuer
     */
    public function setCardDataIssuer($cardDataIssuer)
    {
        $this->cardDataIssuer = $cardDataIssuer;
    }

    /**
     * @return int
     */
    public function getCardDataBin()
    {
        return $this->cardDataBin;
    }

    /**
     * @param int $cardDataBin
     */
    public function setCardDataBin($cardDataBin)
    {
        $this->cardDataBin = $cardDataBin;
    }

    /**
     * @return int
     */
    public function getCardDataMask()
    {
        return $this->cardDataMask;
    }

    /**
     * @param int $cardDataMask
     */
    public function setCardDataMask($cardDataMask)
    {
        $this->cardDataMask = $cardDataMask;
    }

    /**
     * Validates model.
     *
     * @return void
     */
    public function validate()
    {
        if (empty($this->serviceId)) {
            throw new DomainException('ServiceId cannot be empty');
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
        if (!($this->amount == $this->getAmount())) {
            throw new DomainException('Amount in wrong format');
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
        switch ($this->paymentStatus) {
            case self::PAYMENT_STATUS_PENDING:
            case self::PAYMENT_STATUS_SUCCESS:
            case self::PAYMENT_STATUS_FAILURE:
                break;

            default:
                throw new DomainException(sprintf('PaymentStatus="%s" not supported', $this->paymentStatus));
                break;
        }

        if (empty($this->hash)) {
            throw new DomainException('Hash cannot be empty');
        }
    }

    /**
     * Zwraca object data as array.
     *
     * @deprecated Use Transformer::objectToArray()
     * @return array
     */
    public function toArray()
    {
        return Transformer::modelToArray($this);
    }


}
