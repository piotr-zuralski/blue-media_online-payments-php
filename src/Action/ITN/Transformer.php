<?php

namespace BlueMedia\OnlinePayments\Action\ITN;

use BlueMedia\OnlinePayments\Gateway;
use BlueMedia\OnlinePayments\Logger;
use BlueMedia\OnlinePayments\Model\ItnIn;
use DateTime;
use SimpleXMLElement;

/**
 * ITN Transformer
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
     * Is it clearance transaction
     *
     * @param SimpleXMLElement $transaction
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
     * Is it clearance transaction
     *
     * @param ItnIn $itnModel
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
     * Transforms model into an array
     *
     * @param ItnIn $itnModel
     * @return array
     */
    public static function modelToArray(ItnIn $itnModel)
    {
        $isClearanceTransaction = self::isObjectClearanceTransaction($itnModel);

        $result = [];
        $result['customerData'] = [];
        $result['recurringData'] = [];
        $result['cardData'] = [];
        /* 01 */$result['serviceID'] = $itnModel->getServiceId();
        /* 02 */$result['orderID'] = $itnModel->getOrderId();
        /* 03 */$result['remoteID'] = $itnModel->getRemoteId();
        /* 05 */$result['amount'] = $itnModel->getAmount();
        /* 06 */$result['currency'] = $itnModel->getCurrency();
        /* 07 */$result['gatewayID'] = $itnModel->getGatewayId();
        /* 08 */$result['paymentDate'] = (($itnModel->getPaymentDate() instanceof DateTime) ?
            $itnModel->getPaymentDate()->format(Gateway::DATETIME_FORMAT) : ''
        );
        /* 09 */$result['paymentStatus'] = $itnModel->getPaymentStatus();
        /* 10 */$result['paymentStatusDetails'] = $itnModel->getPaymentStatusDetails();
        /* 12 */$result['invoiceNumber'] = $itnModel->getInvoiceNumber();
        /* 13 */$result['customerNumber'] = $itnModel->getCustomerNumber();
        /* 14 */$result['customerEmail'] = $itnModel->getCustomerEmail();

        /* 20 */$result['addressIP'] = $itnModel->getAddressIp();
        /* 21 */if (!empty($itnModel->getTitle()) && !$isClearanceTransaction) {
            $result['title'] = $itnModel->getTitle();
        }
        /* 22 */$result['customerData']['fName'] = $itnModel->getCustomerDatafName();
        /* 23 */$result['customerData']['lName'] = $itnModel->getCustomerDatalName();
        /* 24 */$result['customerData']['streetName'] = $itnModel->getCustomerDataStreetName();
        /* 25 */$result['customerData']['streetHouseNo'] = $itnModel->getCustomerDataStreetHouseNo();
        /* 26 */$result['customerData']['streetStaircaseNo'] = $itnModel->getCustomerDataStreetStaircaseNo();
        /* 27 */$result['customerData']['streetPremiseNo'] = $itnModel->getCustomerDataStreetPremiseNo();
        /* 28 */$result['customerData']['postalCode'] = $itnModel->getCustomerDataPostalCode();
        /* 29 */$result['customerData']['city'] = $itnModel->getCustomerDataCity();
        /* 30 */$result['customerData']['nrb'] = $itnModel->getCustomerDataNrb();
        /* 31 */$result['customerData']['senderData'] = $itnModel->getCustomerDataSenderData();
        /* 32 */$result['verificationStatus'] = $itnModel->getVerificationStatus();
        /* 32 */$result['startAmount'] = $itnModel->getStartAmount();

        /* 40 */$result['transferDate'] = (($itnModel->getTransferDate() instanceof DateTime) ?
            $itnModel->getTransferDate()->format(Gateway::DATETIME_FORMAT) : ''
        );
        /* 41 */$result['transferStatus'] = $itnModel->getTransferStatus();
        /* 42 */$result['transferStatusDetails'] = $itnModel->getTransferStatusDetails();
        /* 43 */$result['title'] = $itnModel->getTitle();
        /* 44 */$result['receiverBank'] = $itnModel->getReceiverBank();
        /* 44 */$result['receiverNRB'] = $itnModel->getReceiverNRB();
        /* 45 */$result['receiverName'] = $itnModel->getReceiverName();
        /* 46 */$result['receiverAddress'] = $itnModel->getReceiverAddress();
        /* 47 */$result['senderBank'] = $itnModel->getSenderBank();
        /* 48 */$result['senderNRB'] = $itnModel->getSenderNRB();

        /* 70 */$result['recurringData']['recurringAction'] = $itnModel->getRecurringDataRecurringAction();
        /* 71 */$result['recurringData']['clientHash'] = $itnModel->getRecurringDataClientHash();
        /* 72 */$result['cardData']['index'] = $itnModel->getCardDataIndex();
        /* 73 */$result['cardData']['validityYear'] = $itnModel->getCardDataValidityYear();
        /* 74 */$result['cardData']['validityMonth'] = $itnModel->getCardDataValidityMonth();
        /* 75 */$result['cardData']['issuer'] = $itnModel->getCardDataIssuer();
        /* 76 */$result['cardData']['bin'] = $itnModel->getCardDataBin();
        /* 77 */$result['cardData']['mask'] = $itnModel->getCardDataMask();

        /* 99 */$result['Hash'] = $itnModel->getHash();

        return $result;
    }

    /**
     * Transforms ITN request into model
     *
     * @param SimpleXMLElement $itn
     * @return ItnIn
     */
    public static function toModel(SimpleXMLElement $itn)
    {
        $transaction = $itn->transactions->transaction;
        $customerData = $transaction->customerData;
        $recurringData = $transaction->recurringData;
        $cardData = $transaction->cardData;
        $isClearanceTransaction = self::isArrayClearanceTransaction($transaction);

        $itnModel = new ItnIn();
        /* 01 */if ($itn->serviceID) {
            $itnModel->setServiceId((string)$itn->serviceID);
        }

        /* 02 */if (isset($transaction->orderID)) {
            $itnModel->setOrderId((string)$transaction->orderID);
        }
        /* 03 */if (isset($transaction->remoteID)) {
            $itnModel->setRemoteId((string)$transaction->remoteID);
        }
        /* 03 */if (isset($transaction->remoteOutID)) {
            $itnModel->setRemoteOutID((string)$transaction->remoteOutID);
        }

        /* 05 */if (isset($transaction->amount)) {
            $itnModel->setAmount((string)$transaction->amount);
        }
        /* 06 */if (isset($transaction->currency)) {
            $itnModel->setCurrency((string)$transaction->currency);
        }
        /* 07 */if (isset($transaction->gatewayID)) {
            $itnModel->setGatewayId((string)$transaction->gatewayID);
        }
        /* 08 */if (isset($transaction->paymentDate)) {
            $paymentDate = DateTime::createFromFormat(Gateway::DATETIME_FORMAT, (string)$transaction->paymentDate);
            $itnModel->setPaymentDate($paymentDate);
            if ($paymentDate > (new DateTime())) {
                Logger::log(
                    Logger::WARNING,
                    sprintf('paymentDate "%s" is in future', $paymentDate->format($paymentDate::ATOM)),
                    ['itn' => $itn]
                );
            }
        }
        /* 09 */if (isset($transaction->paymentStatus)) {
            switch ((string)$transaction->paymentStatus) {
                case ItnIn::PAYMENT_STATUS_PENDING:
                case ItnIn::PAYMENT_STATUS_SUCCESS:
                case ItnIn::PAYMENT_STATUS_FAILURE:
                    $itnModel->setPaymentStatus((string)$transaction->paymentStatus);
                    break;

                default:
                    Logger::log(
                        Logger::EMERGENCY,
                        sprintf('Not supported paymentStatus="%s"', (string)$transaction->paymentStatus),
                        ['itn' => $itn]
                    );
                    break;
            }
        }
        /* 10 */if (isset($transaction->paymentStatusDetails)) {
            switch ((string)$transaction->paymentStatusDetails) {
                case ItnIn::PAYMENT_STATUS_DETAILS_AUTHORIZED:
                case ItnIn::PAYMENT_STATUS_DETAILS_ACCEPTED:
                case ItnIn::PAYMENT_STATUS_DETAILS_REJECTED:
                case ItnIn::PAYMENT_STATUS_DETAILS_INCORRECT_AMOUNT:
                case ItnIn::PAYMENT_STATUS_DETAILS_EXPIRED:
                case ItnIn::PAYMENT_STATUS_DETAILS_CANCELLED:
                case ItnIn::PAYMENT_STATUS_DETAILS_ANOTHER_ERROR:
                case ItnIn::PAYMENT_STATUS_DETAILS_REJECTED_BY_USER:
                    $itnModel->setPaymentStatusDetails((string)$transaction->paymentStatusDetails);
                    break;

                default:
                    Logger::log(
                        Logger::EMERGENCY,
                        sprintf('Not supported paymentStatusDetails="%s"', (string)$transaction->paymentStatusDetails),
                        ['itn' => $itn]
                    );
                    break;
            }
        }
        /* 12 */if (isset($transaction->invoiceNumber)) {
            $itnModel->setInvoiceNumber((string)$transaction->invoiceNumber);
        }
        /* 13 */if (isset($transaction->customerNumber)) {
            $itnModel->setCustomerNumber((string)$transaction->customerNumber);
        }
        /* 14 */if (isset($transaction->customerEmail)) {
            $itnModel->setCustomerEmail((string)$transaction->customerEmail);
        }

        /* 20 */if (isset($transaction->addressIP)) {
            $itnModel->setAddressIp((string)$transaction->addressIP);
        }
        /* 21 */if (isset($transaction->title) && !$isClearanceTransaction) {
            $itnModel->setTitle((string)$transaction->title);
        }
        /* 22 */if (isset($customerData->fName)) {
            $itnModel->setCustomerDatafName((string)$customerData->fName);
        }
        /* 23 */if (isset($customerData->lName)) {
            $itnModel->setCustomerDatalName((string)$customerData->lName);
        }
        /* 24 */if (isset($customerData->streetName)) {
            $itnModel->setCustomerDataStreetName((string)$customerData->streetName);
        }
        /* 25 */if (isset($customerData->streetHouseNo)) {
            $itnModel->setCustomerDataStreetHouseNo((string)$customerData->streetHouseNo);
        }
        /* 26 */if (isset($customerData->streetStaircaseNo)) {
            $itnModel->setCustomerDataStreetStaircaseNo((string)$customerData->streetStaircaseNo);
        }
        /* 27 */if (isset($customerData->streetPremiseNo)) {
            $itnModel->setCustomerDataStreetPremiseNo((string)$customerData->streetPremiseNo);
        }
        /* 28 */if (isset($customerData->postalCode)) {
            $itnModel->setCustomerDataPostalCode((string)$customerData->postalCode);
        }
        /* 29 */if (isset($customerData->city)) {
            $itnModel->setCustomerDataCity((string)$customerData->city);
        }
        /* 30 */if (isset($customerData->nrb)) {
            $itnModel->setCustomerDataNrb((string)$customerData->nrb);
        }
        /* 31 */if (isset($customerData->senderData)) {
            $itnModel->setCustomerDataSenderData((string)$customerData->senderData);
        }
        /* 32 */if (isset($transaction->verificationStatus)) {
            switch ((string)$transaction->verificationStatus) {
                case ItnIn::VERIFICATION_STATUS_NEGATIVE:
                case ItnIn::VERIFICATION_STATUS_PENDING:
                case ItnIn::VERIFICATION_STATUS_POSITIVE:
                    $itnModel->setVerificationStatus((string)$transaction->verificationStatus);
                    break;

                default:
                    Logger::log(
                        Logger::EMERGENCY,
                        sprintf('Not supported verificationStatus="%s"', (string)$transaction->verificationStatus),
                        ['itn' => $itn]
                    );
                    break;
            }
        }
        /* 32 */if (isset($transaction->startAmount)) {
            $itnModel->setStartAmount((string)$transaction->startAmount);
        }

        /* 40 */if (isset($transaction->transferDate)) {
            $transferDate = DateTime::createFromFormat(Gateway::DATETIME_FORMAT, (string)$transaction->transferDate);
            $itnModel->setTransferDate($transferDate);
            if ($transferDate > (new DateTime())) {
                Logger::log(
                    Logger::WARNING,
                    sprintf('transferDate "%s" is in future', $transferDate->format($transferDate::ATOM)),
                    ['itn' => $itn]
                );
            }
        }
        /* 41 */if (isset($transaction->transferStatus)) {
            switch ((string)$transaction->transferStatus) {
                case ItnIn::PAYMENT_STATUS_PENDING:
                case ItnIn::PAYMENT_STATUS_SUCCESS:
                case ItnIn::PAYMENT_STATUS_FAILURE:
                    $itnModel->setTransferStatus((string)$transaction->transferStatus);
                    break;

                default:
                    Logger::log(
                        Logger::EMERGENCY,
                        sprintf('Not supported transferStatus="%s"', (string)$transaction->transferStatus),
                        ['itn' => $itn]
                    );
                    break;
            }
        }
        /* 42 */if (isset($transaction->transferStatusDetails)) {
            switch ((string)$transaction->transferStatusDetails) {
                case ItnIn::PAYMENT_STATUS_DETAILS_AUTHORIZED:
                case ItnIn::PAYMENT_STATUS_DETAILS_CANCELLED:
                case ItnIn::PAYMENT_STATUS_DETAILS_CONFIRMED:
                case ItnIn::PAYMENT_STATUS_DETAILS_ANOTHER_ERROR:
                    $itnModel->setTransferStatusDetails((string)$transaction->transferStatusDetails);
                    break;

                default:
                    Logger::log(
                        Logger::EMERGENCY,
                        sprintf('Not supported transferStatusDetails="%s"', (string)$transaction->transferStatusDetails),
                        ['itn' => $itn]
                    );
                    break;
            }
        }
        /* 43 */if (isset($transaction->title) && $isClearanceTransaction) {
            $itnModel->setTitle((string)$transaction->title);
        }
        /* 44 */if (isset($transaction->receiverBank)) {
            $itnModel->setReceiverBank((string)$transaction->receiverBank);
        }
        /* 44 */if (isset($transaction->receiverNRB)) {
            $itnModel->setReceiverNRB((string)$transaction->receiverNRB);
        }
        /* 45 */if (isset($transaction->receiverName)) {
            $itnModel->setReceiverName((string)$transaction->receiverName);
        }
        /* 46 */if (isset($transaction->receiverAddress)) {
            $itnModel->setReceiverAddress((string)$transaction->receiverAddress);
        }
        /* 47 */if (isset($transaction->senderBank)) {
            $itnModel->setSenderBank((string)$transaction->senderBank);
        }
        /* 48 */if (isset($transaction->senderNRB)) {
            $itnModel->setSenderNRB((string)$transaction->senderNRB);
        }

        /* 70 */if (isset($recurringData->recurringAction)) {
            $itnModel->setRecurringDataRecurringAction((string)$recurringData->recurringAction);
        }
        /* 71 */if (isset($recurringData->clientHash)) {
            $itnModel->setRecurringDataClientHash((string)$recurringData->clientHash);
        }
        /* 72 */if (isset($cardData->index)) {
            $itnModel->setCardDataIndex((string)$cardData->index);
        }
        /* 73 */if (isset($cardData->validityYear)) {
            $itnModel->setCardDataValidityYear((string)$cardData->validityYear);
        }
        /* 74 */if (isset($cardData->validityMonth)) {
            $itnModel->setCardDataValidityMonth((string)$cardData->validityMonth);
        }
        /* 75 */if (isset($cardData->issuer)) {
            $itnModel->setCardDataIssuer((string)$cardData->issuer);
        }
        /* 76 */if (isset($cardData->bin)) {
            $itnModel->setCardDataBin((string)$cardData->bin);
        }
        /* 77 */if (isset($cardData->mask)) {
            $itnModel->setCardDataMask((string)$cardData->mask);
        }

        /* 99 */
        if (isset($itn->hash)) {
            $itnModel->setHash((string)$itn->hash);
        }

        $itnModel->validate();

        return $itnModel;
    }
}
