<?php

namespace BlueMedia\OnlinePayments\Model;

use BlueMedia\OnlinePayments\Formatter;
use BlueMedia\OnlinePayments\Gateway;
use BlueMedia\OnlinePayments\Validator;
use DateTime;
use DomainException;

/**
 * Model for transaction standard.
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments\Model
 * @since     2015-08-08
 * @version   2.3.3
 */
class TransactionStandard extends AbstractModel
{
    /**
     * Service id.
     *
     * @var int
     */
    protected $serviceId;

    /**
     * Transaction order id.
     *
     * @var string
     */
    protected $orderId;

    /**
     * Transaction amount.
     *
     * @var float
     */
    protected $amount;

    /**
     * Transaction description.
     *
     * @var string
     */
    protected $description;

    /**
     * Transaction gateway id.
     *
     * @var int
     */
    protected $gatewayId;

    /**
     * Transaction currency.
     *
     * @var string
     */
    protected $currency;

    /**
     * Transaction customer e-mail address.
     *
     * @var string
     */
    protected $customerEmail;

    /**
     * Transaction customer bank account number.
     *
     * @var string
     */
    protected $customerNrb;

    /**
     * Transaction tax country.
     *
     * @var string
     */
    protected $taxCountry;

    /**
     * Customer IP address.
     *
     * @var string
     */
    protected $customerIp;

    /**
     * Transaction title.
     *
     * @var string
     */
    protected $title;

    /**
     * Transaction receiver name.
     *
     * @var string
     */
    protected $receiverName;

    /**
     * Transaction validity time.
     *
     * @var DateTime
     */
    protected $validityTime;

    /**
     * Transaction link validity time.
     *
     * @var DateTime
     */
    protected $linkValidityTime;

    /**
     * Transaction authorization code.
     *
     * @var string
     */
    protected $authorizationCode;

    /**
     * BLIK Alias UID key.
     *
     * @var string
     */
    protected $blikUIDKey;

    /**
     * BLIK Alias UID label.
     *
     * @var string
     */
    protected $blikUIDLabel;

    /**
     * BLIK banks mobile application key.
     *
     * @var string
     */
    protected $blikAMKey;

    /**
     * Hash.
     *
     * @var string
     */
    protected $hash;

    /**
     * Set amount.
     *
     * @param float $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        $amount = Formatter::formatAmount($amount);
        Validator::validateAmount($amount);
        $this->amount = (float) $amount;

        return $this;
    }

    /**
     * Return amount.
     *
     * @return string
     */
    public function getAmount()
    {
        return Formatter::formatAmount($this->amount);
    }

    /**
     * Set currency.
     *
     * @param string $currency
     *
     * @return $this
     */
    public function setCurrency($currency)
    {
        Validator::validateCurrency($currency);
        $this->currency = (string) mb_strtoupper($currency);

        return $this;
    }

    /**
     * Return currency.
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set customerEmail.
     *
     * @param string $customerEmail
     *
     * @return $this
     */
    public function setCustomerEmail($customerEmail)
    {
        Validator::validateEmail($customerEmail);
        $this->customerEmail = (string) mb_strtolower($customerEmail);

        return $this;
    }

    /**
     * Return customerEmail.
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * Set customerIp.
     *
     * @param string $customerIp
     *
     * @return $this
     */
    public function setCustomerIp($customerIp)
    {
        Validator::validateIP($customerIp);
        $this->customerIp = (string) $customerIp;

        return $this;
    }

    /**
     * Return customerIp.
     *
     * @return string
     */
    public function getCustomerIp()
    {
        return $this->customerIp;
    }

    /**
     * Set customerNrb.
     *
     * @param string $customerNrb
     *
     * @return $this
     */
    public function setCustomerNrb($customerNrb)
    {
        Validator::validateNrb($customerNrb);
        $this->customerNrb = (string) $customerNrb;

        return $this;
    }

    /**
     * Return customerNrb.
     *
     * @return string
     */
    public function getCustomerNrb()
    {
        return $this->customerNrb;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $description = Formatter::formatDescription($description);
        Validator::validateDescription($description);
        $this->description = (string) $description;

        return $this;
    }

    /**
     * Return description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set gatewayId.
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
     * Return gatewayId.
     *
     * @return int
     */
    public function getGatewayId()
    {
        return $this->gatewayId;
    }

    /**
     * Set hash.
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
     * Return hash.
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set orderId.
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
     * Return orderId.
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set receiverName.
     *
     * @param string $receiverName
     *
     * @return $this
     */
    public function setReceiverName($receiverName)
    {
        Validator::validateReceiverName($receiverName);
        $this->receiverName = (string) $receiverName;

        return $this;
    }

    /**
     * Return receiverName.
     *
     * @return string
     */
    public function getReceiverName()
    {
        return $this->receiverName;
    }

    /**
     * Set serviceId.
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
     * Return serviceId.
     *
     * @return int
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
     * Set taxCountry.
     *
     * @param string $taxCountry
     *
     * @return $this
     */
    public function setTaxCountry($taxCountry)
    {
        Validator::validateTaxCountry($taxCountry);
        $this->taxCountry = (string) $taxCountry;

        return $this;
    }

    /**
     * Return taxCountry.
     *
     * @return string
     */
    public function getTaxCountry()
    {
        return $this->taxCountry;
    }

    /**
     * Set title.
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
     * Return title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set linkValidityTime.
     *
     * @param DateTime $linkValidityTime
     *
     * @return $this
     */
    public function setLinkValidityTime(DateTime $linkValidityTime)
    {
        $this->linkValidityTime = $linkValidityTime;

        return $this;
    }

    /**
     * Return linkValidityTime.
     *
     * @return DateTime
     */
    public function getLinkValidityTime()
    {
        return $this->linkValidityTime;
    }

    /**
     * Set validityTime.
     *
     * @param DateTime $validityTime
     *
     * @return $this
     */
    public function setValidityTime(DateTime $validityTime)
    {
        $this->validityTime = $validityTime;

        return $this;
    }

    /**
     * Return validityTime.
     *
     * @return DateTime
     */
    public function getValidityTime()
    {
        return $this->validityTime;
    }

    /**
     * @return string
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * @param  string $authorizationCode
     * @return $this
     */
    public function setAuthorizationCode($authorizationCode)
    {
        $this->authorizationCode = $authorizationCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getBlikUIDKey()
    {
        return $this->blikUIDKey;
    }

    /**
     * @param string $blikUIDKey
     */
    public function setBlikUIDKey($blikUIDKey)
    {
        $this->blikUIDKey = $blikUIDKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getBlikUIDLabel()
    {
        return $this->blikUIDLabel;
    }

    /**
     * @param string $blikUIDLabel
     */
    public function setBlikUIDLabel($blikUIDLabel)
    {
        $this->blikUIDLabel = $blikUIDLabel;

        return $this;
    }

    /**
     * @return string
     */
    public function getBlikAMKey()
    {
        return $this->blikAMKey;
    }

    /**
     * @param string $blikAMKey
     */
    public function setBlikAMKey($blikAMKey)
    {
        $this->blikAMKey = $blikAMKey;

        return $this;
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
        if (empty($this->amount)) {
            throw new DomainException('Amount cannot be empty');
        }
        if (empty($this->hash)) {
            throw new DomainException('Hash cannot be empty');
        }
    }

    /**
     * Return object data as array.
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     *
     * @api
     * @return array
     */
    public function toArray()
    {
        $result = array();
        /* 01 */$result['ServiceID'] = $this->getServiceId();
        /* 02 */$result['OrderID'] = $this->getOrderId();
        /* 03 */$result['Amount'] = $this->getAmount();

        if (!empty($this->getDescription())) {
            $result['Description'] = $this->getDescription();
        }
        if (!empty($this->getGatewayId())) {
            $result['GatewayID'] = $this->getGatewayId();
        }
        if (!empty($this->getCurrency())) {
            $result['Currency'] = $this->getCurrency();
        }
        if (!empty($this->getCustomerEmail())) {
            $result['CustomerEmail'] = $this->getCustomerEmail();
        }
        if (!empty($this->getCustomerNrb())) {
            /* 08 */$result['CustomerNRB'] = $this->getCustomerNrb();
        }
        if (!empty($this->getTaxCountry())) {
            /* 09 */$result['TaxCountry'] = $this->getTaxCountry();
        }
        if (!empty($this->getCustomerIp())) {
            /* 10 */$result['CustomerIP'] = $this->getCustomerIp();
        }
        if (!empty($this->getTitle())) {
            /* 11 */$result['Title'] = $this->getTitle();
        }
        if (!empty($this->getReceiverName())) {
            /* 12 */$result['ReceiverName'] = $this->getReceiverName();
        }
        if (!empty($this->authorizationCode)) {
            /* 40 */$result['AuthorizationCode'] = $this->getAuthorizationCode();
        }
        if (!empty($this->blikUIDKey)) {
            /* 42 */$result['BlikUIDKey'] = $this->getBlikUIDKey();
        }
        if (!empty($this->blikUIDLabel)) {
            /* 43 */$result['BlikUIDLabel'] = $this->getBlikUIDLabel();
        }
        if (!empty($this->blikAMKey)) {
            /* 44 */$result['BlikAMKey'] = $this->getBlikAMKey();
        }

        if ($this->getValidityTime() instanceof DateTime) {
            $result['ValidityTime'] = $this->getValidityTime()->format('Y-m-d H:i:s');
        }
        if ($this->getLinkValidityTime() instanceof DateTime) {
            $result['LinkValidityTime'] = $this->getLinkValidityTime()->format('Y-m-d H:i:s');
        }
        $result['Hash'] = $this->getHash();

        return $result;
    }

    /**
     * Return HTML form.
     *
     * @api
     * @return string
     */
    public function getHtmlForm()
    {
        $result  = '<p>Trwa przekierowanie do Bramki P&#322;atniczej Blue Media...</p>' . PHP_EOL;
        $result .= sprintf(
            '<form action="%s" method="post" id="BlueMediaPaymentForm" name="BlueMediaPaymentForm">',
            Gateway::getActionUrl(Gateway::PAYMENT_ACTON_PAYMENT)
        ) . PHP_EOL;
        foreach ($this->toArray() as $fieldName => $fieldValue) {
            if (empty($fieldValue)) {
                continue;
            }
            $result .= sprintf('<input type="hidden" name="%s" value="%s" />', $fieldName, $fieldValue) . PHP_EOL;
        }
        $result .= '<input type="submit" />' . PHP_EOL;
        $result .= '</form>' . PHP_EOL;
        $result .= '<script type="text/javascript">document.BlueMediaPaymentForm.submit();</script>';
        $result .= '<noscript><p>Masz wy&#322;&#261;czon&#261; obs&#322;ug&#281; JavaScript.<br>';
        $result .= 'Aby przej&#347;&#263; do Bramki P&#322;atniczej Blue Media musi w&#322;&#261;czy&#263; ';
        $result .= 'obs&#322;ug&#281; JavaScript w przegl&#261;darce.</p></noscript>' . PHP_EOL;

        return $result;
    }
}
