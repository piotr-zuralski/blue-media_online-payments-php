<?php

namespace BlueMedia\OnlinePayments;

use RuntimeException;

/**
 * (description) 
 *
 * @author    Piotr Żuralski <piotr.zuralski@invicta.pl>
 * @copyright 2015 INVICTA
 * @package   BlueMedia\OnlinePayments
 * @since     2015-06-28 
 * @version   Release: $Id$
 */
class Gateway 
{
    const MODE_SANDBOX = 'sandbox';
    const MODE_LIVE = 'live';

//    const PAYMENT_DOMAIN_SANDBOX = 'pay-accept.bm.pl';
    const PAYMENT_DOMAIN_SANDBOX = 'httpbin.org';
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

    protected $mode = self::MODE_SANDBOX;

    protected $hashingAlgorithm = '';

    protected $hashingSalt = '';

    protected $serviceId = 0;

    /**
     * Initialize
     *
     * @param string $mode
     * @param string $hashingAlgorithm
         * @param integer $serviceId
         * @param string $hashingSalt

     *
     * @throws RuntimeException
     */
    public function __construct($mode = self::MODE_SANDBOX, $hashingAlgorithm = 'sha256', $serviceId, $hashingSalt)
    {
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


        $this->mode             = $mode;
        $this->hashingAlgorithm = $hashingAlgorithm;
        $this->serviceId        = $serviceId;
        $this->hashingSalt      = $hashingSalt;
    }

    public function doBack()
    {

    }

    public function doITN()
    {

    }

    public function doTransactionBackground()
    {

    }

    public function doTransactionCancel()
    {

    }

    public function doTransactionStandard()
    {

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
     * @param string $mode
     * @param string $action
     *
     * @return string
     */
    final public static function getActionUrl($mode, $action)
    {
        $domain = self::mapModeToDomain($mode);

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
} 