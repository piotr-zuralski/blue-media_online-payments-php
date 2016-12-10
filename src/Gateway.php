<?php

namespace BlueMedia\OnlinePayments;

use BlueMedia\OnlinePayments\Action\ITN\Transformer;
use BlueMedia\OnlinePayments\Model\ItnIn;
use BlueMedia\OnlinePayments\Util\XMLParser;
use GuzzleHttp;
use RuntimeException;
use XMLWriter;

/**
 * Gateway.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments
 * @since     2015-08-08
 * @version   2.3.3
 */
class Gateway
{
    const MODE_SANDBOX = 'sandbox';
    const MODE_LIVE = 'live';

    const PAYMENT_DOMAIN_SANDBOX = 'pay-accept.bm.pl';
    const PAYMENT_DOMAIN_LIVE = 'pay.bm.pl';

    const PAYMENT_ACTON_PAYMENT     = '/payment';

    const STATUS_CONFIRMED = 'CONFIRMED';
    const STATUS_NOT_CONFIRMED = 'NOTCONFIRMED';

    const DATETIME_FORMAT = 'YmdHis';
    const DATETIME_FORMAT_LONGER = 'Y-m-d H:i:s';

    /** @type string */
    private $response = '';

    /** @type int */
    protected static $serviceId = 0;

    /** @type string */
    protected static $hashingSalt = '';

    /** @type string */
    protected static $mode = self::MODE_SANDBOX;

    /** @type string */
    protected static $hashingAlgorithm = '';

    /** @type string */
    protected static $hashingSeparator = '';

    /**
     * List of supported hashing algorithms.
     *
     * @type array
     */
    protected $hashingAlgorithmSupported = [
        'md5' => 1,
        'sha1' => 1,
        'sha256' => 1,
        'sha512' => 1,
    ];

    /**
     * Parse response from Payment System.
     *
     * @return Model\TransactionBackground|string
     */
    private function parseResponse()
    {
        $this->isErrorResponse();
        if ($this->isPaywayFormResponse()) {
            preg_match_all('@<!-- PAYWAY FORM BEGIN -->(.*)<!-- PAYWAY FORM END -->@Usi', $this->response, $data, PREG_PATTERN_ORDER);

            Logger::log(Logger::INFO, 'Got pay way form', ['data' => $data['1']['0'], 'full-response' => $this->response]);

            return htmlspecialchars_decode($data['1']['0']);
        }

        return $this->parseTransferResponse();
    }

    /**
     * Parses transfer response.
     *
     * @return Model\TransactionBackground
     */
    private function parseTransferResponse()
    {
        $xmlData = XMLParser::parse($this->response);

        $transactionBackground = new Model\TransactionBackground();
        $transactionBackground
            ->setReceiverNrb((string)$xmlData->receiverNRB)
            ->setReceiverName((string)$xmlData->receiverName)
            ->setReceiverAddress((string)$xmlData->receiverAddress)
            ->setOrderId((string)$xmlData->orderID)
            ->setAmount((string)$xmlData->amount)
            ->setCurrency((string)$xmlData->currency)
            ->setTitle((string)$xmlData->title)
            ->setRemoteId((string)$xmlData->remoteID)
            ->setBankHref((string)$xmlData->bankHref)
            ->setHash((string)$xmlData->hash);

        $transactionBackgroundHash = self::generateHash($transactionBackground->toArray());
        if ($transactionBackgroundHash !== $transactionBackground->getHash()) {
            Logger::log(
                Logger::EMERGENCY,
                sprintf(
                    'Received wrong hash, calculated hash "%s", received hash "%s"',
                    $transactionBackgroundHash,
                    $transactionBackground->getHash()
                ),
                ['data' => $transactionBackground->toArray(), 'full-response' => $this->response]
            );
            throw new RuntimeException('Received wrong hash!');
        }

        return $transactionBackground;
    }

    /**
     * Is error response.
     *
     * @return void
     */
    private function isErrorResponse()
    {
        if (preg_match_all('@<error>(.*)</error>@Usi', $this->response, $data, PREG_PATTERN_ORDER)) {
            $xmlData = XMLParser::parse($this->response);
            Logger::log(
                Logger::EMERGENCY,
                sprintf('Got error: "%s", code: "%s"', $xmlData->name, $xmlData->statusCode),
                ['data' => $xmlData, 'full-response' => $this->response]
            );
            var_dump($xmlData);
            throw new RuntimeException($xmlData->name);
        }
    }

    /**
     * Is pay way form response.
     *
     * @return int
     */
    private function isPaywayFormResponse()
    {
        return (preg_match_all('@<!-- PAYWAY FORM BEGIN -->(.*)<!-- PAYWAY FORM END -->@Usi', $this->response, $data, PREG_PATTERN_ORDER));
    }

    /**
     * Checks PHP required environment.
     *
     * @throws \RuntimeException
     *
     * @return void
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
     * Initialize.
     *
     * @api
     *
     * @param int    $serviceId
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

        if ($mode !== self::MODE_LIVE && $mode !== self::MODE_SANDBOX) {
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

        self::$mode = $mode;
        self::$hashingAlgorithm = $hashingAlgorithm;
        self::$serviceId = $serviceId;
        self::$hashingSalt = $hashingSalt;
        self::$hashingSeparator = $hashingSeparator;
    }

    /**
     * Process ITN requests.
     *
     * @api
     *
     * @return Model\ItnIn|null
     */
    public function doItnIn()
    {
        if (empty($_POST['transactions'])) {
            Logger::log(
                Logger::INFO,
                sprintf('No "transactions" field in POST data'),
                ['_POST' => $_POST]
            );

            return;
        }

        $transactionXml = $_POST['transactions'];
        $transactionXml = base64_decode($transactionXml, true);
        $transactionData = XMLParser::parse($transactionXml);

        Logger::log(
            Logger::DEBUG,
            sprintf('Got "transactions" field in POST data'),
            [
                'data-raw' => $_POST['transactions'],
                'data-xml' => $transactionXml,
            ]
        );

        return Transformer::toModel($transactionData);
    }

    /**
     * Returns response for ITN IN request.
     *
     * @api
     *
     * @param ItnIn $transaction
     * @param bool  $transactionConfirmed
     *
     * @return string
     */
    public function doItnInResponse(Model\ItnIn $transaction, $transactionConfirmed = true)
    {
        $transactionHash = self::generateHash(Transformer::modelToArray($transaction));
        $confirmationStatus = self::STATUS_NOT_CONFIRMED;

        if ($transactionHash === $transaction->getHash()) {
            $confirmationStatus = self::STATUS_CONFIRMED;
        }
        if (!$transactionConfirmed) {
            $confirmationStatus = self::STATUS_NOT_CONFIRMED;
        }

        $confirmationList = [
            'serviceID' => self::$serviceId,
            'orderID' => $transaction->getOrderId(),
            'confirmation' => $confirmationStatus,
        ];

        $confirmationList['hash'] = self::generateHash($confirmationList);

        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->startDocument('1.0', 'UTF-8');
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

    /**
     * Perform transaction in background.
     *
     * @api
     *
     * @param Model\TransactionStandard $transaction
     *
     * @return Model\TransactionBackground|string
     */
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
        $this->response = (string) $responseObject->getBody();

        return $this->parseResponse();
    }

    /**
     * Perform standard transaction.
     *
     * @api
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
     * Maps payment mode to service payment domain.
     *
     * @api
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
     * Maps payment mode to service payment URL.
     *
     * @api
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
     * Returns payment service action URL.
     *
     * @api
     *
     * @param string $action
     *
     * @return string
     */
    final public static function getActionUrl($action)
    {
        $domain = self::mapModeToDomain(self::$mode);

        switch ($action) {
            case self::PAYMENT_ACTON_PAYMENT:
                break;

            default:
                $message = sprintf('Requested action "%s" not supported', $action);
                Logger::log(Logger::EMERGENCY, $message);
                throw new RuntimeException($message);
                break;
        }

        return sprintf('https://%s%s', $domain, $action);
    }

    /**
     * Generates hash.
     *
     * @param array $data
     *
     * @return string
     */
    final public static function generateHash(array $data)
    {
        $result = '';
        foreach ($data as $name => $value) {
            if (mb_strtolower($name) === 'hash' || empty($value)) {
                unset($data[$name]);
                continue;
            }
            if (is_array($value)) {
                $value = array_filter($value, 'mb_strlen');
                $value = join(self::$hashingSeparator, $value);
            }
            if (!empty($value)) {
                $result .= $value . self::$hashingSeparator;
            }
        }
        $result .= self::$hashingSalt;

        return hash(self::$hashingAlgorithm, $result);
    }

}
