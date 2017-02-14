<?php

namespace BlueMedia\OnlinePayments\Action\ITN;

use BlueMedia\OnlinePayments\Gateway;
use BlueMedia\OnlinePayments\Logger;
use BlueMedia\OnlinePayments\Model\ItnIn;
use DateTime;
use DateTimeZone;
use SimpleXMLElement;

/**
 * ITN Transformer.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2016 Blue Media
 * @package   BlueMedia\OnlinePayments\Action\ITN
 * @since     2016-12-06
 * @version   2.3.3
 */
class Transformer
{
    /**
     * Is it clearance transaction.
     *
     * @param  SimpleXMLElement $transaction
     * @return bool
     */
    private static function isArrayClearanceTransaction(SimpleXMLElement $transaction)
    {
        return (
            isset($transaction->transferDate) ||
            isset($transaction->transferStatus) ||
            isset($transaction->transferStatusDetails) ||
            isset($transaction->receiverBank) ||
            isset($transaction->receiverNRB) ||
            isset($transaction->receiverName) ||
            isset($transaction->receiverAddress) ||
            isset($transaction->senderBank) ||
            isset($transaction->senderNRB)
        );
    }

    /**
     * Is it clearance transaction.
     *
     * @param  ItnIn $itnModel
     * @return bool
     */
    private static function isObjectClearanceTransaction(ItnIn $itnModel)
    {
        return (
            !empty($itnModel->getTransferDate()) ||
            !empty($itnModel->getTransferStatus()) ||
            !empty($itnModel->getTransferStatusDetails()) ||
            !empty($itnModel->getReceiverBank()) ||
            !empty($itnModel->getReceiverNRB()) ||
            !empty($itnModel->getReceiverName()) ||
            !empty($itnModel->getReceiverAddress()) ||
            !empty($itnModel->getSenderBank()) ||
            !empty($itnModel->getSenderNRB())
        );
    }

    /**
     * Transforms model into an array.
     *
     * @param  ItnIn $model
     * @return array
     */
    public static function modelToArray(ItnIn $model)
    {
        $isClearanceTransaction = self::isObjectClearanceTransaction($model);

        $result = array();
        $result['customerData'] = array();
        $result['recurringData'] = array();
        $result['cardData'] = array();
        /* 01 */$result['serviceID'] = $model->getServiceId();
        /* 02 */$result['orderID'] = $model->getOrderId();
        /* 03 */$result['remoteID'] = $model->getRemoteId();
        /* 05 */$result['amount'] = $model->getAmount();
        /* 06 */$result['currency'] = $model->getCurrency();
        /* 07 */$result['gatewayID'] = $model->getGatewayId();
        /* 08 */$result['paymentDate'] = (($model->getPaymentDate() instanceof DateTime) ?
            $model->getPaymentDate()->format(Gateway::DATETIME_FORMAT) : ''
        );
        /* 09 */$result['paymentStatus'] = $model->getPaymentStatus();
        /* 10 */$result['paymentStatusDetails'] = $model->getPaymentStatusDetails();
        /* 12 */$result['invoiceNumber'] = $model->getInvoiceNumber();
        /* 13 */$result['customerNumber'] = $model->getCustomerNumber();
        /* 14 */$result['customerEmail'] = $model->getCustomerEmail();

        /* 20 */$result['addressIP'] = $model->getAddressIp();
        /* 21 */if (!empty($model->getTitle()) && !$isClearanceTransaction) {
            $result['title'] = $model->getTitle();
        }
        /* 22 */$result['customerData']['fName'] = $model->getCustomerDatafName();
        /* 23 */$result['customerData']['lName'] = $model->getCustomerDatalName();
        /* 24 */$result['customerData']['streetName'] = $model->getCustomerDataStreetName();
        /* 25 */$result['customerData']['streetHouseNo'] = $model->getCustomerDataStreetHouseNo();
        /* 26 */$result['customerData']['streetStaircaseNo'] = $model->getCustomerDataStreetStaircaseNo();
        /* 27 */$result['customerData']['streetPremiseNo'] = $model->getCustomerDataStreetPremiseNo();
        /* 28 */$result['customerData']['postalCode'] = $model->getCustomerDataPostalCode();
        /* 29 */$result['customerData']['city'] = $model->getCustomerDataCity();
        /* 30 */$result['customerData']['nrb'] = $model->getCustomerDataNrb();
        /* 31 */$result['customerData']['senderData'] = $model->getCustomerDataSenderData();
        /* 32 */$result['verificationStatus'] = $model->getVerificationStatus();
        /* 32 */$result['startAmount'] = $model->getStartAmount();

        /* 40 */$result['transferDate'] = (($model->getTransferDate() instanceof DateTime) ?
            $model->getTransferDate()->format(Gateway::DATETIME_FORMAT) : ''
        );
        /* 41 */$result['transferStatus'] = $model->getTransferStatus();
        /* 42 */$result['transferStatusDetails'] = $model->getTransferStatusDetails();
        /* 43 */$result['title'] = $model->getTitle();
        /* 44 */$result['receiverBank'] = $model->getReceiverBank();
        /* 44 */$result['receiverNRB'] = $model->getReceiverNRB();
        /* 45 */$result['receiverName'] = $model->getReceiverName();
        /* 46 */$result['receiverAddress'] = $model->getReceiverAddress();
        /* 47 */$result['senderBank'] = $model->getSenderBank();
        /* 48 */$result['senderNRB'] = $model->getSenderNRB();

        /* 70 */$result['recurringData']['recurringAction'] = $model->getRecurringDataRecurringAction();
        /* 71 */$result['recurringData']['clientHash'] = $model->getRecurringDataClientHash();
        /* 72 */$result['cardData']['index'] = $model->getCardDataIndex();
        /* 73 */$result['cardData']['validityYear'] = $model->getCardDataValidityYear();
        /* 74 */$result['cardData']['validityMonth'] = $model->getCardDataValidityMonth();
        /* 75 */$result['cardData']['issuer'] = $model->getCardDataIssuer();
        /* 76 */$result['cardData']['bin'] = $model->getCardDataBin();
        /* 77 */$result['cardData']['mask'] = $model->getCardDataMask();

        /* 99 */$result['Hash'] = $model->getHash();

        return $result;
    }

    /**
     * Transforms ITN request into model.
     *
     * @param  SimpleXMLElement $xml
     * @return ItnIn
     */
    public static function toModel(SimpleXMLElement $xml)
    {
        $transaction = $xml->transactions->transaction;
        $customerData = $transaction->customerData;
        $recurringData = $transaction->recurringData;
        $cardData = $transaction->cardData;
        $isClearanceTransaction = self::isArrayClearanceTransaction($transaction);

        $model = new ItnIn();
        /* 01 */if (isset($xml->serviceID)) {
            $model->setServiceId((string) $xml->serviceID);
        }

        /* 02 */if (isset($transaction->orderID)) {
            $model->setOrderId((string) $transaction->orderID);
        }
        /* 03 */if (isset($transaction->remoteID)) {
            $model->setRemoteId((string) $transaction->remoteID);
        }
        /* 03 */if (isset($transaction->remoteOutID)) {
            $model->setRemoteOutID((string) $transaction->remoteOutID);
        }

        /* 05 */if (isset($transaction->amount)) {
            $model->setAmount((string) $transaction->amount);
        }
        /* 06 */if (isset($transaction->currency)) {
            $model->setCurrency((string) $transaction->currency);
        }
        /* 07 */if (isset($transaction->gatewayID)) {
            $model->setGatewayId((string) $transaction->gatewayID);
        }
        /* 08 */if (isset($transaction->paymentDate)) {
            $paymentDate = DateTime::createFromFormat(
                Gateway::DATETIME_FORMAT,
                (string) $transaction->paymentDate,
                new DateTimeZone(Gateway::DATETIME_TIMEZONE)
            );
            $model->setPaymentDate($paymentDate);
            if ($paymentDate > (new DateTime('now', new DateTimeZone(Gateway::DATETIME_TIMEZONE)))) {
                Logger::log(
                    Logger::WARNING,
                    sprintf('paymentDate "%s" is in future', $paymentDate->format($paymentDate::ATOM)),
                    array('itn' => $xml)
                );
            }
        }
        /* 09 */if (isset($transaction->paymentStatus)) {
            switch ((string) $transaction->paymentStatus) {
                case ItnIn::PAYMENT_STATUS_PENDING:
                case ItnIn::PAYMENT_STATUS_SUCCESS:
                case ItnIn::PAYMENT_STATUS_FAILURE:
                    $model->setPaymentStatus((string) $transaction->paymentStatus);
                    break;

                default:
                    Logger::log(
                        Logger::EMERGENCY,
                        sprintf('Not supported paymentStatus="%s"', (string) $transaction->paymentStatus),
                        array('itn' => $xml)
                    );
                    break;
            }
        }
        /* 10 */if (isset($transaction->paymentStatusDetails)) {
            switch ((string) $transaction->paymentStatusDetails) {
                case ItnIn::PAYMENT_STATUS_DETAILS_AUTHORIZED:
                case ItnIn::PAYMENT_STATUS_DETAILS_ACCEPTED:
                case ItnIn::PAYMENT_STATUS_DETAILS_REJECTED:
                case ItnIn::PAYMENT_STATUS_DETAILS_INCORRECT_AMOUNT:
                case ItnIn::PAYMENT_STATUS_DETAILS_EXPIRED:
                case ItnIn::PAYMENT_STATUS_DETAILS_CANCELLED:
                case ItnIn::PAYMENT_STATUS_DETAILS_ANOTHER_ERROR:
                case ItnIn::PAYMENT_STATUS_DETAILS_REJECTED_BY_USER:
                    $model->setPaymentStatusDetails((string) $transaction->paymentStatusDetails);
                    break;

                default:
                    Logger::log(
                        Logger::EMERGENCY,
                        sprintf('Not supported paymentStatusDetails="%s"', (string) $transaction->paymentStatusDetails),
                        array('itn' => $xml)
                    );
                    break;
            }
        }
        /* 12 */if (isset($transaction->invoiceNumber)) {
            $model->setInvoiceNumber((string) $transaction->invoiceNumber);
        }
        /* 13 */if (isset($transaction->customerNumber)) {
            $model->setCustomerNumber((string) $transaction->customerNumber);
        }
        /* 14 */if (isset($transaction->customerEmail)) {
            $model->setCustomerEmail((string) $transaction->customerEmail);
        }

        /* 20 */if (isset($transaction->addressIP)) {
            $model->setAddressIp((string) $transaction->addressIP);
        }
        /* 21 */if (isset($transaction->title) && !$isClearanceTransaction) {
            $model->setTitle((string) $transaction->title);
        }
        /* 22 */if (isset($customerData->fName)) {
            $model->setCustomerDatafName((string) $customerData->fName);
        }
        /* 23 */if (isset($customerData->lName)) {
            $model->setCustomerDatalName((string) $customerData->lName);
        }
        /* 24 */if (isset($customerData->streetName)) {
            $model->setCustomerDataStreetName((string) $customerData->streetName);
        }
        /* 25 */if (isset($customerData->streetHouseNo)) {
            $model->setCustomerDataStreetHouseNo((string) $customerData->streetHouseNo);
        }
        /* 26 */if (isset($customerData->streetStaircaseNo)) {
            $model->setCustomerDataStreetStaircaseNo((string) $customerData->streetStaircaseNo);
        }
        /* 27 */if (isset($customerData->streetPremiseNo)) {
            $model->setCustomerDataStreetPremiseNo((string) $customerData->streetPremiseNo);
        }
        /* 28 */if (isset($customerData->postalCode)) {
            $model->setCustomerDataPostalCode((string) $customerData->postalCode);
        }
        /* 29 */if (isset($customerData->city)) {
            $model->setCustomerDataCity((string) $customerData->city);
        }
        /* 30 */if (isset($customerData->nrb)) {
            $model->setCustomerDataNrb((string) $customerData->nrb);
        }
        /* 31 */if (isset($customerData->senderData)) {
            $model->setCustomerDataSenderData((string) $customerData->senderData);
        }
        /* 32 */if (isset($transaction->verificationStatus)) {
            switch ((string) $transaction->verificationStatus) {
                case ItnIn::VERIFICATION_STATUS_NEGATIVE:
                case ItnIn::VERIFICATION_STATUS_PENDING:
                case ItnIn::VERIFICATION_STATUS_POSITIVE:
                    $model->setVerificationStatus((string) $transaction->verificationStatus);
                    break;

                default:
                    Logger::log(
                        Logger::EMERGENCY,
                        sprintf('Not supported verificationStatus="%s"', (string) $transaction->verificationStatus),
                        array('itn' => $xml)
                    );
                    break;
            }
        }
        /* 32 */if (isset($transaction->startAmount)) {
            $model->setStartAmount((string) $transaction->startAmount);
        }

        /* 40 */if (isset($transaction->transferDate)) {
            $transferDate = DateTime::createFromFormat(
                Gateway::DATETIME_FORMAT,
                (string) $transaction->transferDate,
                new DateTimeZone(Gateway::DATETIME_TIMEZONE)
            );
            $model->setTransferDate($transferDate);
            if ($transferDate > (new DateTime('now', new DateTimeZone(Gateway::DATETIME_TIMEZONE)))) {
                Logger::log(
                    Logger::WARNING,
                    sprintf('transferDate "%s" is in future', $transferDate->format($transferDate::ATOM)),
                    array('itn' => $xml)
                );
            }
        }
        /* 41 */if (isset($transaction->transferStatus)) {
            switch ((string) $transaction->transferStatus) {
                case ItnIn::PAYMENT_STATUS_PENDING:
                case ItnIn::PAYMENT_STATUS_SUCCESS:
                case ItnIn::PAYMENT_STATUS_FAILURE:
                    $model->setTransferStatus((string) $transaction->transferStatus);
                    break;

                default:
                    Logger::log(
                        Logger::EMERGENCY,
                        sprintf('Not supported transferStatus="%s"', (string) $transaction->transferStatus),
                        array('itn' => $xml)
                    );
                    break;
            }
        }
        /* 42 */if (isset($transaction->transferStatusDetails)) {
            switch ((string) $transaction->transferStatusDetails) {
                case ItnIn::PAYMENT_STATUS_DETAILS_AUTHORIZED:
                case ItnIn::PAYMENT_STATUS_DETAILS_CANCELLED:
                case ItnIn::PAYMENT_STATUS_DETAILS_CONFIRMED:
                case ItnIn::PAYMENT_STATUS_DETAILS_ANOTHER_ERROR:
                    $model->setTransferStatusDetails((string) $transaction->transferStatusDetails);
                    break;

                default:
                    Logger::log(
                        Logger::EMERGENCY,
                        sprintf('Not supported transferStatusDetails="%s"', (string) $transaction->transferStatusDetails),
                        array('itn' => $xml)
                    );
                    break;
            }
        }
        /* 43 */if (isset($transaction->title) && $isClearanceTransaction) {
            $model->setTitle((string) $transaction->title);
        }
        /* 44 */if (isset($transaction->receiverBank)) {
            $model->setReceiverBank((string) $transaction->receiverBank);
        }
        /* 44 */if (isset($transaction->receiverNRB)) {
            $model->setReceiverNRB((string) $transaction->receiverNRB);
        }
        /* 45 */if (isset($transaction->receiverName)) {
            $model->setReceiverName((string) $transaction->receiverName);
        }
        /* 46 */if (isset($transaction->receiverAddress)) {
            $model->setReceiverAddress((string) $transaction->receiverAddress);
        }
        /* 47 */if (isset($transaction->senderBank)) {
            $model->setSenderBank((string) $transaction->senderBank);
        }
        /* 48 */if (isset($transaction->senderNRB)) {
            $model->setSenderNRB((string) $transaction->senderNRB);
        }

        /* 70 */if (isset($recurringData->recurringAction)) {
            $model->setRecurringDataRecurringAction((string) $recurringData->recurringAction);
        }
        /* 71 */if (isset($recurringData->clientHash)) {
            $model->setRecurringDataClientHash((string) $recurringData->clientHash);
        }
        /* 72 */if (isset($cardData->index)) {
            $model->setCardDataIndex((string) $cardData->index);
        }
        /* 73 */if (isset($cardData->validityYear)) {
            $model->setCardDataValidityYear((string) $cardData->validityYear);
        }
        /* 74 */if (isset($cardData->validityMonth)) {
            $model->setCardDataValidityMonth((string) $cardData->validityMonth);
        }
        /* 75 */if (isset($cardData->issuer)) {
            $model->setCardDataIssuer((string) $cardData->issuer);
        }
        /* 76 */if (isset($cardData->bin)) {
            $model->setCardDataBin((string) $cardData->bin);
        }
        /* 77 */if (isset($cardData->mask)) {
            $model->setCardDataMask((string) $cardData->mask);
        }

        /* 99 */
        if (isset($xml->hash)) {
            $model->setHash((string) $xml->hash);
        }

        $model->validate();

        return $model;
    }
}
