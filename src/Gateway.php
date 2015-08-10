<?php

namespace BlueMedia\OnlinePayments;

use BlueMedia\OnlinePayments\Model;
use DateTime;
use GuzzleHttp;
use XMLReader;
use XMLWriter;
use RuntimeException;

/**
 * Gateway
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments
 * @since     2015-08-08
 * @version   2.3.1
 */
class Gateway 
{
    const MODE_SANDBOX = 'sandbox';
    const MODE_LIVE = 'live';

    const PAYMENT_DOMAIN_SANDBOX = 'pay-accept.bm.pl';
    const PAYMENT_DOMAIN_LIVE = 'payment.blue.pl';

    const PAYMENT_ACTON_SECURE = '/secure?';
    const PAYMENT_ACTON_PAYMENT = '/payment?';
    const PAYMENT_ACTON_CANCEL = '/transactionCancel?';
    const PAYMENT_ACTON_START_TRAN = '/startTran?';

    const STATUS_CONFIRMED = 'CONFIRMED';
    const STATUS_NOT_CONFIRMED = 'NOTCONFIRMED';


    protected $hashingAlgorithmSupported = [
        'md5' => 1,
        'sha1' => 1,
        'sha256' => 1,
        'sha512' => 1,
    ];

    protected static $mode = self::MODE_SANDBOX;

    protected static $hashingAlgorithm = '';

    protected static $hashingSalt = '';

    protected static $hashingSeparator = '';

    protected static $serviceId = 0;

    private $response = '';

    private function parseResponse()
    {
        $this->isErrorResponse();
        if ($this->isPaywayFormResponse()) {
            preg_match_all('@<!-- PAYWAY FORM BEGIN -->(.*)<!-- PAYWAY FORM END -->@Usi', $this->response, $data, PREG_PATTERN_ORDER);
            return htmlspecialchars_decode($data['1']['0']);
        }
        return $this->parseTransferResponse();
    }

    private function parseTransferResponse()
    {
        $xmlData = $this->parseXml($this->response);

        $transactionBackground = new Model\TransactionBackground();
        $transactionBackground
            ->setReceiverNrb($xmlData['receiverNRB'])
            ->setReceiverName($xmlData['receiverName'])
            ->setReceiverAddress($xmlData['receiverAddress'])
            ->setOrderId($xmlData['orderID'])
            ->setAmount($xmlData['amount'])
            ->setCurrency($xmlData['currency'])
            ->setTitle($xmlData['title'])
            ->setRemoteId($xmlData['remoteID'])
            ->setBankHref($xmlData['bankHref'])
            ->setHash($xmlData['hash']);

        $transactionBackgroundHash = self::generateHash($transactionBackground->toArray());
        if ($transactionBackgroundHash !== $transactionBackground->getHash()) {
            throw new RuntimeException('Received wrong hash!');
        }
        return $transactionBackground;
    }

    private function isErrorResponse()
    {
        if (preg_match_all('@<error>(.*)</error>@Usi',$this->response, $data, PREG_PATTERN_ORDER)) {
            $xmlData = $this->parseXml($this->response);
            throw new RuntimeException($xmlData['name'], $xmlData['statusCode']);
        }
    }

    private function isPaywayFormResponse()
    {
        return (preg_match_all('@<!-- PAYWAY FORM BEGIN -->(.*)<!-- PAYWAY FORM END -->@Usi', $this->response, $data, PREG_PATTERN_ORDER));
    }

    private function parseXml($xml)
    {
        $data = [];
        $xmlReader = new XMLReader();
        $xmlReader->XML($xml, 'UTF-8', (LIBXML_NOERROR | LIBXML_NOWARNING));
        while ($xmlReader->read()) {
            switch ($xmlReader->nodeType) {
                case XMLREADER::ELEMENT:
                    $nodeName = $xmlReader->name;
                    $xmlReader->read();
                    $nodeValue = $xmlReader->value;
                    if (!empty($nodeName) && !empty(trim($nodeValue))) {
                        $data[$nodeName] = $nodeValue;
                    }
                    break;
            }
        }
        $xmlReader->close();
        return $data;
    }

    /**
     * Checks PHP required environment
     *
     * @return void
     * @throws \RuntimeException
     */
    protected function checkPhpEnvironment()
    {
        if (!version_compare(PHP_VERSION, '5.5', '>=')) {
            throw new RuntimeException(sprintf('Required at least PHP version 5.5, current version "%s"', PHP_VERSION));
        }
        if (!extension_loaded('xmlwriter')) {
            throw new RuntimeException('Extension "xmlwriter" is required');
        }
        if (!extension_loaded('xmlreader')) {
            throw new RuntimeException('Extension "xmlreader" is required');
        }
        if (!extension_loaded('iconv')) {
            throw new RuntimeException('Extension "iconv" is required');
        }
        if (!extension_loaded('mbstring')) {
            throw new RuntimeException('Extension "mbstring" is required');
        }
        if (!extension_loaded('hash')) {
            throw new RuntimeException('Extension "hash" is required');
        }
    }

    /**
     * Initialize
     *
     * @param integer $serviceId
     * @param string $hashingSalt
     * @param string $mode
     * @param string $hashingAlgorithm
     * @param string $hashingSeparator
     *
     * @throws RuntimeException
     */
    public function __construct($serviceId, $hashingSalt, $mode = self::MODE_SANDBOX, $hashingAlgorithm = 'sha256', $hashingSeparator = '|')
    {
        $this->checkPhpEnvironment();

        if ($mode != self::MODE_LIVE && $mode != self::MODE_SANDBOX) {
            throw new RuntimeException(sprintf('Not supported mode "%s"', $mode));
        }
        if (!array_key_exists($hashingAlgorithm, $this->hashingAlgorithmSupported)) {
            throw new RuntimeException(sprintf('Not supported hashingAlgorithm "%s"', $hashingAlgorithm));
        }
        if (empty($serviceId) || !is_numeric($serviceId)) {
            throw new RuntimeException(sprintf('Not supported serviceId "%s" - must be integer, %s given', $serviceId, gettype($serviceId)));
        }
        if (empty($hashingSalt) || !is_string($hashingSalt)) {
            throw new RuntimeException(sprintf('Not supported hashingSalt "%s" - must be string, %s given', $hashingSalt, gettype($hashingSalt)));
        }

        self::$mode             = $mode;
        self::$hashingAlgorithm = $hashingAlgorithm;
        self::$serviceId        = $serviceId;
        self::$hashingSalt      = $hashingSalt;
        self::$hashingSeparator = $hashingSeparator;
    }

    /**
     * Process ITN IN requests
     *
     * @return Model\ItnIn|null
     */
    public function doItnIn()
    {
        if (empty($_POST['transactions'])) {
            return null;
        }

        $transactionXml = $_POST['transactions'];
        $transactionXml = base64_decode($transactionXml);
        $transactionData = $this->parseXml($transactionXml);

        $itnIn = new Model\ItnIn();
        $itnIn->setServiceId($transactionData['serviceID'])
            ->setOrderId($transactionData['orderID'])
            ->setRemoteId($transactionData['remoteID'])
            ->setAmount($transactionData['amount'])
            ->setCurrency($transactionData['currency'])
            ->setGatewayId($transactionData['gatewayID'])
            ->setPaymentDate(DateTime::createFromFormat('YmdHis', $transactionData['paymentDate']))
            ->setPaymentStatus($transactionData['paymentStatus'])
            ->setPaymentStatusDetails($transactionData['paymentStatusDetails'])
            ->setHash($transactionData['hash']);

        return $itnIn;
    }

    /**
     * Returns response for ITN IN request
     *
     * @param Model\ItnIn $transaction
     *
     * @return string
     */
    public function doItnInResponse(Model\ItnIn $transaction)
    {
        $transactionHash = self::generateHash($transaction->toArray());
        $confirmationStatus = self::STATUS_NOT_CONFIRMED;

        if ($transactionHash == $transaction->getHash()) {
            $confirmationStatus = self::STATUS_CONFIRMED;
        }

        $confirmationList = [
            'serviceID' => self::$serviceId,
            'orderID' => $transaction->getOrderId(),
            'confirmation' => $confirmationStatus,
        ];

        $confirmationList['hash'] = self::generateHash($confirmationList);

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->startDocument(1.0, 'UTF-8');
        $xml->startElement('confirmationList');
            $xml->writeElement('serviceID', $confirmationList['serviceID']);
                $xml->startElement('transactionsConfirmations');
                    $xml->startElement('transactionConfirmed');
                        $xml->writeElement('orderID', $confirmationList['orderID']);
                        $xml->writeElement('confirmation', $confirmationList['confirmation']);
                    $xml->endElement();
                $xml->endElement();
            $xml->writeElement('hash', $confirmationList['hash']);
        $xml->endElement();

        return $xml->outputMemory();
    }

    public function doTransactionBackground(Model\TransactionStandard $transaction)
    {
        $transaction->setServiceId(self::$serviceId);
        $transaction->setHash(self::generateHash($transaction->toArray()));
        $transaction->validate();

        $url = self::getActionUrl(self::PAYMENT_ACTON_PAYMENT);
        $request = new GuzzleHttp\Psr7\Request('POST', $url, ['BmHeader' => 'pay-bm']);

        $client = new GuzzleHttp\Client([
            GuzzleHttp\RequestOptions::VERIFY => true,
            'exceptions' => false,
        ]);

        $responseObject = $client->send($request, [GuzzleHttp\RequestOptions::FORM_PARAMS => $transaction->toArray()]);
        $this->response = (string)$responseObject->getBody();
        return $this->parseResponse();
    }

    /**
     * Perform standard transaction
     *
     * @param Model\TransactionStandard $transaction
     *
     * @return string
     */
    public function doTransactionStandard(Model\TransactionStandard $transaction)
    {
        $transaction->setServiceId(self::$serviceId);
        $transaction->setHash(self::generateHash($transaction->toArray()));
        $transaction->validate();
        return $transaction->getHtmlForm();
    }

    /**
     * Maps payment mode to service payment domain
     *
     * @param string $mode
     *
     * @return string
     */
    final public static function mapModeToDomain($mode)
    {
        switch ($mode) {
            case self::MODE_LIVE:
                return self::PAYMENT_DOMAIN_LIVE;

            default:
                return self::PAYMENT_DOMAIN_SANDBOX;
        }
    }

    /**
     * Maps payment mode to service payment URL
     *
     * @param string $mode
     *
     * @return string
     */
    final public static function mapModeToUrl($mode)
    {
        $domain = self::mapModeToDomain($mode);
        return sprintf('https://%s', $domain);
    }

    /**
     * Returns payment service action URL
     *
     * @param string $action
     *
     * @return string
     */
    final public static function getActionUrl($action)
    {
        $domain = self::mapModeToDomain(self::$mode);

        switch ($action) {
            case self::PAYMENT_ACTON_CANCEL:
            case self::PAYMENT_ACTON_PAYMENT:
            case self::PAYMENT_ACTON_SECURE:
            case self::PAYMENT_ACTON_START_TRAN:
                break;

            /* if any other value */
            default:
                $action = self::PAYMENT_ACTON_SECURE;
                break;
        }

        return sprintf('https://%s%s', $domain, $action);
    }

    final public static function generateHash(array $data)
    {
        $result = '';
        foreach ($data as $name => $value) {
            if (mb_strtolower($name) == 'hash' || empty($value)) {
                continue;
            }
            $result .= $value . self::$hashingSeparator;
        }
        $result .= self::$hashingSalt;
        return hash(self::$hashingAlgorithm, $result);
    }
} 