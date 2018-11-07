<?php

namespace BlueMedia\OnlinePayments;

use BlueMedia\OnlinePayments\Action\ITN;
use BlueMedia\OnlinePayments\Action\PaywayList;
use BlueMedia\OnlinePayments\Model\ItnIn;
use BlueMedia\OnlinePayments\Util\EnvironmentRequirements;
use BlueMedia\OnlinePayments\Util\HttpClient;
use BlueMedia\OnlinePayments\Util\XMLParser;
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
    const PAYMENT_ACTON_PAYWAY_LIST = '/paywayList';

    const STATUS_CONFIRMED = 'CONFIRMED';
    const STATUS_NOT_CONFIRMED = 'NOTCONFIRMED';

    const DATETIME_FORMAT = 'YmdHis';
    const DATETIME_FORMAT_LONGER = 'Y-m-d H:i:s';
    const DATETIME_TIMEZONE = 'Europe/Warsaw';

    const HASH_MD5    = 'md5';
    const HASH_SHA1   = 'sha1';
    const HASH_SHA256 = 'sha256';
    const HASH_SHA512 = 'sha512';

    const PATTERN_PAYWAY = '@<!-- PAYWAY FORM BEGIN -->(.*)<!-- PAYWAY FORM END -->@Usi';
    const PATTERN_XML_ERROR = '@<error>(.*)</error>@Usi';
    const PATTERN_GENERAL_ERROR = '/error(.*)/si';

    /** @var string */
    private $response = '';

    /** @var int */
    protected static $serviceId = 0;

    /** @var string */
    protected static $hashingSalt = '';

    /** @var string */
    protected static $mode = self::MODE_SANDBOX;

    /** @var string */
    protected static $hashingAlgorithm = '';

    /** @var string */
    protected static $hashingSeparator = '';

    /**
     * List of supported hashing algorithms.
     *
     * @var array
     */
    protected $hashingAlgorithmSupported = array(
        self::HASH_MD5    => 1,
        self::HASH_SHA1   => 1,
        self::HASH_SHA256 => 1,
        self::HASH_SHA512 => 1,
    );

    /** @var HttpClient */
    protected static $httpClient = null;

    /**
     * Parse response from Payment System.
     *
     * @return Model\TransactionBackground|string
     */
    private function parseResponse()
    {
        $this->isErrorResponse();
        if ($this->isPaywayFormResponse()) {
            preg_match_all(self::PATTERN_PAYWAY, $this->response, $data, PREG_PATTERN_ORDER);

            Logger::log(
                Logger::INFO,
                'Got pay way form',
                array(
                    'data' => $data['1']['0'],
                    'full-response' => $this->response,
                )
            );

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
            ->setReceiverNrb((string) $xmlData->receiverNRB)
            ->setReceiverName((string) $xmlData->receiverName)
            ->setReceiverAddress((string) $xmlData->receiverAddress)
            ->setOrderId((string) $xmlData->orderID)
            ->setAmount((string) $xmlData->amount)
            ->setCurrency((string) $xmlData->currency)
            ->setTitle((string) $xmlData->title)
            ->setRemoteId((string) $xmlData->remoteID)
            ->setBankHref((string) $xmlData->bankHref)
            ->setHash((string) $xmlData->hash);

        $transactionBackgroundHash = self::generateHash($transactionBackground->toArray());
        if ($transactionBackgroundHash !== $transactionBackground->getHash()) {
            Logger::log(
                Logger::EMERGENCY,
                sprintf(
                    'Received wrong hash, calculated hash "%s", received hash "%s"',
                    $transactionBackgroundHash,
                    $transactionBackground->getHash()
                ),
                array(
                    'data' => $transactionBackground->toArray(),
                    'full-response' => $this->response,
                )
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
        if (preg_match_all(self::PATTERN_XML_ERROR, $this->response, $data, PREG_PATTERN_ORDER)) {
            $xmlData = XMLParser::parse($this->response);
            Logger::log(
                Logger::EMERGENCY,
                sprintf('Got error: "%s", code: "%s"', $xmlData->name, $xmlData->statusCode),
                array(
                    'data' => $xmlData,
                    'full-response' => $this->response,
                )
            );
            throw new RuntimeException((string) $xmlData->name);
        } elseif (preg_match_all(self::PATTERN_GENERAL_ERROR, $this->response, $data, PREG_PATTERN_ORDER)) {
            throw new RuntimeException($this->response);
        }
    }

    /**
     * Is pay way form response.
     *
     * @return int
     */
    private function isPaywayFormResponse()
    {
        return (preg_match_all(self::PATTERN_PAYWAY, $this->response, $data, PREG_PATTERN_ORDER));
    }

    /**
     * Checks PHP required environment.
     *
     * @codeCoverageIgnore
     * @throws \RuntimeException
     *
     * @return void
     */
    protected function checkPhpEnvironment()
    {
        if (EnvironmentRequirements::hasSupportedPhpVersion()) {
            throw new RuntimeException(sprintf('Required at least PHP version 5.5, current version "%s"', PHP_VERSION));
        }
        if (!EnvironmentRequirements::hasPhpExtension('xmlwriter')) {
            throw new RuntimeException('Extension "xmlwriter" is required');
        }
        if (!EnvironmentRequirements::hasPhpExtension('xmlreader')) {
            throw new RuntimeException('Extension "xmlreader" is required');
        }
        if (!EnvironmentRequirements::hasPhpExtension('iconv')) {
            throw new RuntimeException('Extension "iconv" is required');
        }
        if (!EnvironmentRequirements::hasPhpExtension('mbstring')) {
            throw new RuntimeException('Extension "mbstring" is required');
        }
        if (!EnvironmentRequirements::hasPhpExtension('hash')) {
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
    public function __construct(
        $serviceId,
        $hashingSalt,
        $mode = self::MODE_SANDBOX,
        $hashingAlgorithm = self::HASH_SHA256,
        $hashingSeparator = '|'
    ) {
        $this->checkPhpEnvironment();

        if ($mode !== self::MODE_LIVE && $mode !== self::MODE_SANDBOX) {
            throw new RuntimeException(sprintf('Not supported mode "%s"', $mode));
        }
        if (!array_key_exists($hashingAlgorithm, $this->hashingAlgorithmSupported)) {
            throw new RuntimeException(sprintf('Not supported hashingAlgorithm "%s"', $hashingAlgorithm));
        }
        if (empty($serviceId) || !is_numeric($serviceId)) {
            throw new RuntimeException(sprintf(
                'Not supported serviceId "%s" - must be integer, %s given',
                $serviceId,
                gettype($serviceId)
            ));
        }
        if (empty($hashingSalt) || !is_string($hashingSalt)) {
            throw new RuntimeException(sprintf(
                'Not supported hashingSalt "%s" - must be string, %s given',
                $hashingSalt,
                gettype($hashingSalt)
            ));
        }

        self::$mode = $mode;
        self::$hashingAlgorithm = $hashingAlgorithm;
        self::$serviceId = $serviceId;
        self::$hashingSalt = $hashingSalt;
        self::$hashingSeparator = $hashingSeparator;
        self::$httpClient = new HttpClient();
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
                array(
                    '_POST' => $_POST,
                )
            );

            return;
        }

        $transactionXml = $_POST['transactions'];
        $transactionXml = base64_decode($transactionXml, true);
        $transactionData = XMLParser::parse($transactionXml);

        Logger::log(
            Logger::DEBUG,
            sprintf('Got "transactions" field in POST data'),
            array(
                'data-raw' => $_POST['transactions'],
                'data-xml' => $transactionXml,
            )
        );

        return ITN\Transformer::toModel($transactionData);
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
        $transaction->validate();
        $transactionHash = self::generateHash(ITN\Transformer::modelToArray($transaction));
        $confirmationStatus = self::STATUS_NOT_CONFIRMED;

        if ($transactionHash === $transaction->getHash()) {
            $confirmationStatus = self::STATUS_CONFIRMED;
        }
        if (!$transactionConfirmed) {
            $confirmationStatus = self::STATUS_NOT_CONFIRMED;
        }

        $confirmationList = array(
            'serviceID' => self::$serviceId,
            'orderID' => $transaction->getOrderId(),
            'confirmation' => $confirmationStatus,
        );

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

        $responseObject = self::$httpClient->post(
            self::getActionUrl(self::PAYMENT_ACTON_PAYMENT),
            array('BmHeader' => 'pay-bm'),
            $transaction->toArray()
        );

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
            case self::PAYMENT_ACTON_PAYWAY_LIST:
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
                $value = implode(self::$hashingSeparator, $value);
            }
            if (!empty($value)) {
                $result .= $value . self::$hashingSeparator;
            }
        }
        $result .= self::$hashingSalt;

        return hash(self::$hashingAlgorithm, $result);
    }

    /**
     * Returns payway list.
     *
     * @api
     * @return \BlueMedia\OnlinePayments\Action\PaywayList\Model
     * @throws RuntimeException
     */
    final public function doPaywayList()
    {
        $fields = array(
            'ServiceID' => self::$serviceId,
            'MessageID' => $this->generateMessageId(),
        );
        $fields['Hash'] = self::generateHash($fields);

        $responseObject = self::$httpClient->post(
            self::getActionUrl(self::PAYMENT_ACTON_PAYWAY_LIST),
            array(),
            $fields
        );

        $this->response = (string) $responseObject->getBody();
        $this->isErrorResponse();

        $responseParsed = XMLParser::parse($this->response);

        $model = PaywayList\Transformer::toModel($responseParsed);
        $model->validate((int) $fields['ServiceID'], (string) $fields['MessageID']);

        return $model;
    }

    /**
     * Generates unique MessageId.
     *
     * @return string
     */
    public function generateMessageId()
    {
        return md5(time());
    }
}
