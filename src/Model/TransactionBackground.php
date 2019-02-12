<?php

namespace BlueMedia\OnlinePayments\Model;

use BlueMedia\OnlinePayments\Formatter;
use BlueMedia\OnlinePayments\Validator;
use DomainException;

/**
 * Model for transaction in background.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments\Model
 * @since     2015-08-08
 * @version   2.3.3
 */
class TransactionBackground extends AbstractModel
{
    /**
     * Receiver bank account number.
     *
     * @required
     * @var string
     */
    protected $receiverNrb;

    /**
     * Receiver name.
     *
     * @required
     * @var string
     */
    protected $receiverName;

    /**
     * Receiver address.
     *
     * @required
     * @var string
     */
    protected $receiverAddress;

    /**
     * Order id.
     *
     * @required
     * @var string
     */
    protected $orderId;

    /**
     * Amount.
     *
     * @required
     * @var float
     */
    protected $amount;

    /**
     * Currency.
     *
     * @required
     * @var string
     */
    protected $currency;

    /**
     * Title.
     *
     * @required
     * @var string
     */
    protected $title;

    /**
     * Remote order id.
     *
     * @required
     * @var string
     */
    protected $remoteId;

    /**
     * Banks system URL.
     *
     * @required
     * @var string
     */
    protected $bankHref;

    /**
     * Hash.
     *
     * @required
     * @var string
     */
    protected $hash;

    /**
     * Sets amount.
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
     * Returns amount.
     *
     * @return string
     */
    public function getAmount()
    {
        return Formatter::formatAmount($this->amount);
    }

    /**
     * Sets bankHref.
     *
     * @param string $bankHref
     *
     * @return $this
     */
    public function setBankHref($bankHref)
    {
        $this->bankHref = (string) $bankHref;

        return $this;
    }

    /**
     * Returns bankHref.
     *
     * @return string
     */
    public function getBankHref()
    {
        return $this->bankHref;
    }

    /**
     * Sets currency.
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
     * Returns currency.
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Sets hash.
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
     * Returns hash.
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Sets orderId.
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
     * Returns orderId.
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Sets receiverAddress.
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
     * Returns receiverAddress.
     *
     * @return string
     */
    public function getReceiverAddress()
    {
        return $this->receiverAddress;
    }

    /**
     * Sets receiverName.
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
     * Returns receiverName.
     *
     * @return string
     */
    public function getReceiverName()
    {
        return $this->receiverName;
    }

    /**
     * Sets receiverNrb.
     *
     * @param string $receiverNrb
     *
     * @return $this
     */
    public function setReceiverNrb($receiverNrb)
    {
        Validator::validateNrb($receiverNrb);
        $this->receiverNrb = (string) $receiverNrb;

        return $this;
    }

    /**
     * Returns receiverNrb.
     *
     * @return string
     */
    public function getReceiverNrb()
    {
        return $this->receiverNrb;
    }

    /**
     * Sets remoteId.
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
     * Returns remoteId.
     *
     * @return string
     */
    public function getRemoteId()
    {
        return $this->remoteId;
    }

    /**
     * Sets title.
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
     * Returns title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
    * @SuppressWarnings(PHPMD.CyclomaticComplexity)
    * @SuppressWarnings(PHPMD.NPathComplexity)
    */
    public function validate()
    {
        if (empty($this->receiverNrb)) {
            throw new DomainException('ReceiverNrb cannot be empty');
        }
        if (empty($this->receiverName)) {
            throw new DomainException('ReceiverName cannot be empty');
        }
        if (empty($this->receiverAddress)) {
            throw new DomainException('ReceiverAddress cannot be empty');
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
        if (empty($this->title)) {
            throw new DomainException('Title cannot be empty');
        }
        if (empty($this->remoteId)) {
            throw new DomainException('RemoteId cannot be empty');
        }
        if (empty($this->bankHref)) {
            throw new DomainException('BankHref cannot be empty');
        }
        if (empty($this->hash)) {
            throw new DomainException('Hash cannot be empty');
        }
    }

    public function toArray()
    {
        $result = array();
        $result['receiverNRB'] = $this->getReceiverNrb();
        $result['receiverName'] = $this->getReceiverName();
        $result['receiverAddress'] = $this->getReceiverAddress();
        $result['orderID'] = $this->getOrderId();
        $result['amount'] = $this->getAmount();
        $result['currency'] = $this->getCurrency();
        $result['title'] = $this->getTitle();
        $result['remoteID'] = $this->getRemoteId();
        $result['bankHref'] = $this->getBankHref();
        $result['hash'] = $this->getHash();

        return $result;
    }
}
