<?php

namespace BlueMedia\OnlinePayments\Tests\Unit;

use BlueMedia\OnlinePayments\Action\PaywayList;
use BlueMedia\OnlinePayments\Gateway;
use BlueMedia\OnlinePayments\Logger;
use BlueMedia\OnlinePayments\Model;
use BlueMedia\OnlinePayments\Model\ItnIn;
use BlueMedia\OnlinePayments\Util\HttpClient;
use Codeception\Util\Stub;
use Psr\Log\NullLogger;

/**
 * Gateway test.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2015 Blue Media
 * @package   BlueMedia\OnlinePayments\Tests
 * @since     2015-08-08
 * @version   2.3.3
 */
class GatewayTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var int
     */
    private $serviceId = 123456;

    /**
     * @var string
     */
    private $hashingSalt = '81532ad38b71944834059480537b324bd1ab2bd9';

    /**
     * @var string
     */
    private $hashingSeparator = '|';

    /**
     * @var Gateway
     */
    private $gateway = null;

    protected function _before()
    {
        Logger::setLogger(new NullLogger());

        $this->gateway = new Gateway(
            $this->serviceId,
            $this->hashingSalt,
            Gateway::MODE_SANDBOX,
            'sha256',
            $this->hashingSeparator
        );
    }

    protected function _after()
    {
        unset($this->gateway);
    }

    private function makePostTransactionsFromFixture($file)
    {
        $_POST['transactions'] = base64_encode($this->tester->returnStaticFileFromFixture($file));
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not supported mode "BETA"
     * @expectedExceptionCode 0
     */
    public function testConstructWithInvalidMode()
    {
        $gateway = new Gateway(
            $this->serviceId,
            $this->hashingSalt,
            'BETA',
            'sha256',
            $this->hashingSeparator
        );

        $this->tester->assertNull($gateway);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not supported hashingAlgorithm "sha384"
     * @expectedExceptionCode 0
     */
    public function testConstructWithInvalidHashingAlgorithm()
    {
        $gateway = new Gateway(
            $this->serviceId,
            $this->hashingSalt,
            Gateway::MODE_SANDBOX,
            'sha384',
            $this->hashingSeparator
        );

        $this->tester->assertNull($gateway);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not supported hashingSalt
     * @expectedExceptionCode 0
     */
    public function testConstructWithInvalidHashingSalt()
    {
        $gateway = new Gateway(
            $this->serviceId,
            null,
            Gateway::MODE_SANDBOX,
            'sha256',
            $this->hashingSeparator
        );

        $this->tester->assertNull($gateway);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not supported serviceId "abcxyz" - must be integer, string given
     * @expectedExceptionCode 0
     */
    public function testConstructWithInvalidServiceId()
    {
        $gateway = new Gateway(
            'abcxyz',
            $this->hashingSalt,
            Gateway::MODE_SANDBOX,
            'sha256',
            $this->hashingSeparator
        );

        $this->tester->assertNull($gateway);
    }

    /**
     * @group ItnIn
     */
    public function testDoItnInWithFailedStatus()
    {
        $this->makePostTransactionsFromFixture('ItnIn-FailedStatus.xml');

        /** @var Model\ItnIn $model */
        $model = $this->gateway->doItnIn();

        $this->tester->assertInstanceOf(Model\ItnIn::class, $model);
        $this->tester->assertNull($model->validate());
        $this->tester->assertSame(100014, $model->getServiceId());
        $this->tester->assertSame('1438950364', $model->getOrderId());
        $this->tester->assertSame('96LQJ7F2', $model->getRemoteId());
        $this->tester->assertSame('123.00', $model->getAmount());
        $this->tester->assertSame('PLN', $model->getCurrency());
        $this->tester->assertSame(106, $model->getGatewayId());
        $this->tester->assertSame('2015-08-07T14:26:49+02:00', $model->getPaymentDate()->format(\DateTime::ATOM));
        $this->tester->assertSame('FAILURE', $model->getPaymentStatus());
        $this->tester->assertSame('REJECTED', $model->getPaymentStatusDetails());
        $this->tester->assertNull($model->getAddressIp());
        $this->tester->assertNull($model->getTitle());
        $this->tester->assertNull($model->getCustomerDatafName());
        $this->tester->assertNull($model->getCustomerDatalName());
        $this->tester->assertNull($model->getCustomerDataStreetName());
        $this->tester->assertNull($model->getCustomerDataStreetHouseNo());
        $this->tester->assertNull($model->getCustomerDataStreetStaircaseNo());
        $this->tester->assertNull($model->getCustomerDataStreetPremiseNo());
        $this->tester->assertNull($model->getCustomerDataPostalCode());
        $this->tester->assertNull($model->getCustomerDataCity());
        $this->tester->assertNull($model->getCustomerDataNrb());
        $this->tester->assertNull($model->getTransferDate());
        $this->tester->assertNull($model->getTransferStatus());
        $this->tester->assertNull($model->getTransferStatusDetails());
        $this->tester->assertNull($model->getReceiverNRB());
        $this->tester->assertNull($model->getReceiverName());
        $this->tester->assertNull($model->getReceiverAddress());
        $this->tester->assertNull($model->getReceiverBank());
        $this->tester->assertNull($model->getSenderNRB());
        $this->tester->assertSame('c6106d230cf1a94e0081765de2df3271a4327bb7e0fcd8d76ca634a121b9a5b1', $model->getHash());
        $this->tester->assertNull($model->getRemoteOutID());
        $this->tester->assertNull($model->getInvoiceNumber());
        $this->tester->assertNull($model->getCustomerNumber());
        $this->tester->assertNull($model->getCustomerEmail());
        $this->tester->assertNull($model->getCustomerPhone());
        $this->tester->assertNull($model->getCustomerDataSenderData());
        $this->tester->assertNull($model->getVerificationStatus());
        $this->tester->assertNull($model->getVerificationStatusReasons());
        $this->tester->assertNull($model->getStartAmount());
        $this->tester->assertNull($model->getRecurringDataRecurringAction());
        $this->tester->assertNull($model->getRecurringDataClientHash());
        $this->tester->assertNull($model->getCardDataIndex());
        $this->tester->assertNull($model->getCardDataValidityYear());
        $this->tester->assertNull($model->getCardDataValidityMonth());
        $this->tester->assertNull($model->getCardDataIssuer());
        $this->tester->assertNull($model->getCardDataBin());
        $this->tester->assertNull($model->getCardDataMask());
    }

    /**
     * @group ItnIn
     */
    public function testDoItnInWithPendingStatus()
    {
        $this->makePostTransactionsFromFixture('ItnIn-PendingStatus.xml');

        /** @var Model\ItnIn $model */
        $model = $this->gateway->doItnIn();

        $this->tester->assertInstanceOf(Model\ItnIn::class, $model);
        $this->tester->assertNull($model->validate());
        $this->tester->assertSame(100660, $model->getServiceId());
        $this->tester->assertSame('1481064980', $model->getOrderId());
        $this->tester->assertSame('96JMT7QG', $model->getRemoteId());
        $this->tester->assertSame('9877.54', $model->getAmount());
        $this->tester->assertSame('PLN', $model->getCurrency());
        $this->tester->assertSame(106, $model->getGatewayId());
        $this->tester->assertSame('2016-12-06T23:56:11+01:00', $model->getPaymentDate()->format(\DateTime::ATOM));
        $this->tester->assertSame('PENDING', $model->getPaymentStatus());
        $this->tester->assertNull($model->getPaymentStatusDetails());
        $this->tester->assertSame('192.168.0.34', $model->getAddressIp());
        $this->tester->assertNull($model->getTitle());
        $this->tester->assertNull($model->getCustomerDatafName());
        $this->tester->assertNull($model->getCustomerDatalName());
        $this->tester->assertNull($model->getCustomerDataStreetName());
        $this->tester->assertNull($model->getCustomerDataStreetHouseNo());
        $this->tester->assertNull($model->getCustomerDataStreetStaircaseNo());
        $this->tester->assertNull($model->getCustomerDataStreetPremiseNo());
        $this->tester->assertNull($model->getCustomerDataPostalCode());
        $this->tester->assertNull($model->getCustomerDataCity());
        $this->tester->assertNull($model->getCustomerDataNrb());
        $this->tester->assertNull($model->getTransferDate());
        $this->tester->assertNull($model->getTransferStatus());
        $this->tester->assertNull($model->getTransferStatusDetails());
        $this->tester->assertNull($model->getReceiverNRB());
        $this->tester->assertNull($model->getReceiverName());
        $this->tester->assertNull($model->getReceiverAddress());
        $this->tester->assertNull($model->getReceiverBank());
        $this->tester->assertNull($model->getSenderNRB());
        $this->tester->assertSame('2f006dd1ed8c242ac960213cbafd6679ff9f1095805e04eb56f96cc67e51e5f4', $model->getHash());
        $this->tester->assertNull($model->getRemoteOutID());
        $this->tester->assertNull($model->getInvoiceNumber());
        $this->tester->assertNull($model->getCustomerNumber());
        $this->tester->assertNull($model->getCustomerEmail());
        $this->tester->assertNull($model->getCustomerPhone());
        $this->tester->assertNull($model->getCustomerDataSenderData());
        $this->tester->assertNull($model->getVerificationStatus());
        $this->tester->assertNull($model->getVerificationStatusReasons());
        $this->tester->assertSame(9876.54, $model->getStartAmount());
        $this->tester->assertNull($model->getRecurringDataRecurringAction());
        $this->tester->assertNull($model->getRecurringDataClientHash());
        $this->tester->assertNull($model->getCardDataIndex());
        $this->tester->assertNull($model->getCardDataValidityYear());
        $this->tester->assertNull($model->getCardDataValidityMonth());
        $this->tester->assertNull($model->getCardDataIssuer());
        $this->tester->assertNull($model->getCardDataBin());
        $this->tester->assertNull($model->getCardDataMask());
    }

    /**
     * @group ItnIn
     */
    public function testDoItnInWithSuccessStatus()
    {
        $this->makePostTransactionsFromFixture('ItnIn-SuccessStatus.xml');

        /** @var Model\ItnIn $model */
        $model = $this->gateway->doItnIn();

        $this->tester->assertInstanceOf(Model\ItnIn::class, $model);
        $this->tester->assertNull($model->validate());
        $this->tester->assertSame(100660, $model->getServiceId());
        $this->tester->assertSame('1481064927', $model->getOrderId());
        $this->tester->assertSame('96JMSU8K', $model->getRemoteId());
        $this->tester->assertSame('9877.54', $model->getAmount());
        $this->tester->assertSame('PLN', $model->getCurrency());
        $this->tester->assertSame(106, $model->getGatewayId());
        $this->tester->assertSame('2016-12-06T23:55:39+01:00', $model->getPaymentDate()->format(\DateTime::ATOM));
        $this->tester->assertSame('SUCCESS', $model->getPaymentStatus());
        $this->tester->assertSame('AUTHORIZED', $model->getPaymentStatusDetails());
        $this->tester->assertSame('192.168.0.34', $model->getAddressIp());
        $this->tester->assertSame('BPID:96JMSU8K Test transaction', $model->getTitle());
        $this->tester->assertSame('Jan', $model->getCustomerDatafName());
        $this->tester->assertSame('Kowalski', $model->getCustomerDatalName());
        $this->tester->assertSame('Jasna', $model->getCustomerDataStreetName());
        $this->tester->assertSame('6', $model->getCustomerDataStreetHouseNo());
        $this->tester->assertSame('A', $model->getCustomerDataStreetStaircaseNo());
        $this->tester->assertSame('3', $model->getCustomerDataStreetPremiseNo());
        $this->tester->assertSame('10-234', $model->getCustomerDataPostalCode());
        $this->tester->assertSame('Warszawa', $model->getCustomerDataCity());
        $this->tester->assertSame('26105014451000002276470461', $model->getCustomerDataNrb());
        $this->tester->assertNull($model->getTransferDate());
        $this->tester->assertNull($model->getTransferStatus());
        $this->tester->assertNull($model->getTransferStatusDetails());
        $this->tester->assertNull($model->getReceiverNRB());
        $this->tester->assertNull($model->getReceiverName());
        $this->tester->assertNull($model->getReceiverAddress());
        $this->tester->assertNull($model->getReceiverBank());
        $this->tester->assertNull($model->getSenderNRB());
        $this->tester->assertSame('fc787a482e9bd0f707223de3c687a96f3f9a3ed8922d8291a5dfc061a997fb20', $model->getHash());
        $this->tester->assertNull($model->getRemoteOutID());
        $this->tester->assertNull($model->getInvoiceNumber());
        $this->tester->assertNull($model->getCustomerNumber());
        $this->tester->assertNull($model->getCustomerEmail());
        $this->tester->assertNull($model->getCustomerPhone());
        $this->tester->assertSame('Jan Kowalski Jasna 6/A/3 10-234 Warszawa', $model->getCustomerDataSenderData());
        $this->tester->assertNull($model->getVerificationStatus());
        $this->tester->assertNull($model->getVerificationStatusReasons());
        $this->tester->assertSame(9876.54, $model->getStartAmount());
        $this->tester->assertNull($model->getRecurringDataRecurringAction());
        $this->tester->assertNull($model->getRecurringDataClientHash());
        $this->tester->assertNull($model->getCardDataIndex());
        $this->tester->assertNull($model->getCardDataValidityYear());
        $this->tester->assertNull($model->getCardDataValidityMonth());
        $this->tester->assertNull($model->getCardDataIssuer());
        $this->tester->assertNull($model->getCardDataBin());
        $this->tester->assertNull($model->getCardDataMask());
    }

    /**
     * @group ItnIn
     */
    public function testDoItnInWithoutParameters()
    {
        $itnIn = $this->gateway->doItnIn();
        $this->tester->assertNull($itnIn);
    }

    /**
     * @coversDefaultClass ItnIn
     */
    public function testDoItnInResponseForNotConfirmedTransaction()
    {
        $model = $this->tester->returnPhpFileFromFixture('ItnIn-Full-PBL-PG-Test.php');

        $this->tester->assertInstanceOf(Model\ItnIn::class, $model);
        $response = $this->gateway->doItnInResponse($model, false);
        $this->tester->assertSame($this->tester->returnStaticFileFromFixture('ItnInResponse-NOTCONFIRMED.xml'), $response);
    }

    /**
     * @coversDefaultClass ItnIn
     */
    public function testDoItnInResponseForConfirmedTransaction()
    {
        $model = $this->tester->returnPhpFileFromFixture('ItnIn-PaymentStatus-Success.php');

        $this->tester->assertInstanceOf(Model\ItnIn::class, $model);
        $response = $this->gateway->doItnInResponse($model, true);
        $this->tester->assertSame($this->tester->returnStaticFileFromFixture('ItnInResponse-CONFIRMED.xml'), $response);
    }

    /**
     * @group TransactionBackground
     */
    public function testDoTransactionBackgroundWithPaywayForm()
    {
        $httpClient = Stub::make(new HttpClient(), array(
                'post' => Stub::make(\GuzzleHttp\Psr7\Response::class, array(
                        'getStatusCode' => 200,
                        'getBody' => $this->tester->returnStaticFileFromFixture('TransactionBackground-Payway-form-PBL.html'),
                    )),
            ));
        $this->gateway = Stub::make($this->gateway, array(
            'httpClient' => $httpClient,
        ));

        $model = $this->tester->returnPhpFileFromFixture('TransactionStandard.php');
        $response = $this->gateway->doTransactionBackground($model);

        $this->tester->assertInstanceOf(Model\TransactionStandard::class, $model);
        $this->tester->assertSame(
            $this->tester->returnStaticFileFromFixture('TransactionBackground-Payway-form-PBL-response.html'),
            $response
        );
    }

    /**
     * @group TransactionBackground
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Nieznany błąd
     * @expectedExceptionCode 0
     */
    public function testDoTransactionBackgroundWithIllegalParamsErrorResponse()
    {
        $httpClient = Stub::make(new HttpClient(), array(
                'post' => Stub::make(\GuzzleHttp\Psr7\Response::class, array(
                        'getStatusCode' => 405,
                        'getBody' => $this->tester->returnStaticFileFromFixture(
                            'TransactionBackground-error-illegal-params.xml'
                        ),
                    )),
            ));
        $this->gateway = Stub::make($this->gateway, array(
            'httpClient' => $httpClient,
        ));

        $model = $this->tester->returnPhpFileFromFixture('TransactionStandard.php');
        $response = $this->gateway->doTransactionBackground($model);

        $this->tester->assertInstanceOf(Model\TransactionStandard::class, $model);
        $this->tester->assertSame(
            $this->tester->returnStaticFileFromFixture('TransactionBackground-Payway-form-PBL-response.html'),
            $response
        );
    }

    /**
     * @group TransactionBackground
     * @expectedException \RuntimeException
     * @expectedExceptionMessage PAYWAY_NOT_FOUND
     * @expectedExceptionCode 0
     */
    public function testDoTransactionBackgroundWithPayWayNotFoundErrorResponse()
    {
        $httpClient = Stub::make(new HttpClient(), array(
                'post' => Stub::make(\GuzzleHttp\Psr7\Response::class, array(
                        'getStatusCode' => 500,
                        'getBody' => $this->tester->returnStaticFileFromFixture(
                            'TransactionBackground-error-PAYWAY_NOT_FOUND.xml'
                        ),
                    )),
            ));
        $this->gateway = Stub::make($this->gateway, array(
            'httpClient' => $httpClient,
        ));

        $model = $this->tester->returnPhpFileFromFixture('TransactionStandard.php');
        $response = $this->gateway->doTransactionBackground($model);

        $this->tester->assertInstanceOf(Model\TransactionStandard::class, $model);
        $this->tester->assertSame(
            $this->tester->returnStaticFileFromFixture('TransactionBackground-Payway-form-PBL-response.html'),
            $response
        );
    }

    /**
     * @group TransactionBackground
     */
    public function testDoTransactionBackgroundWithTransferResponse()
    {
        $httpClient = Stub::make(new HttpClient(), array(
                'post' => Stub::make(\GuzzleHttp\Psr7\Response::class, array(
                        'getStatusCode' => 200,
                        'getBody' => $this->tester->returnStaticFileFromFixture('TransactionBackground-Transfer.xml'),
                    )),
            ));
        $this->gateway = Stub::make($this->gateway, array(
            'httpClient' => $httpClient,
        ));

        $model = $this->tester->returnPhpFileFromFixture('TransactionStandard.php');
        $response = $this->gateway->doTransactionBackground($model);

        $this->tester->assertInstanceOf(Model\TransactionBackground::class, $response);
        $this->tester->assertSame('83213000042001031174540004', $response->getReceiverNrb());
        $this->tester->assertSame('Blue Media S.A.', $response->getReceiverName());
        $this->tester->assertSame('81-717 Sopot, Haffnera 6', $response->getReceiverAddress());
        $this->tester->assertSame('1507132335', $response->getOrderId());
        $this->tester->assertSame('12.95', $response->getAmount());
        $this->tester->assertSame('PLN', $response->getCurrency());
        $this->tester->assertSame('97Y2BSR9 Test transaction', $response->getTitle());
        $this->tester->assertSame('97Y2BSR9', $response->getRemoteId());
        $this->tester->assertSame('https://login.vwbankdirect.pl/', $response->getBankHref());
        $this->tester->assertSame('05d0a689a7021faab3827a08e7cf7f465a553d53423c372ff980766e92536b78', $response->getHash());
    }

    /**
     * @group TransactionBackground
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Received wrong hash!
     * @expectedExceptionCode 0
     */
    public function testDoTransactionBackgroundWithTransferResponseWithWrongHashShouldThrowException()
    {
        $httpClient = Stub::make(new HttpClient(), array(
                'post' => Stub::make(\GuzzleHttp\Psr7\Response::class, array(
                        'getStatusCode' => 200,
                        'getBody' => $this->tester->returnStaticFileFromFixture(
                            'TransactionBackground-Transfer-wrong-hash.xml'
                        ),
                    )),
            ));
        $this->gateway = Stub::make($this->gateway, array(
            'httpClient' => $httpClient,
        ));

        $model = $this->tester->returnPhpFileFromFixture('TransactionStandard.php');
        $response = $this->gateway->doTransactionBackground($model);

        $this->tester->assertNull($response);
    }

    /**
     * @group TransactionStandard
     */
    public function testDoTransactionStandard()
    {
        $model = $this->tester->returnPhpFileFromFixture('TransactionStandard.php');
        $html = $this->gateway->doTransactionStandard($model);

        $this->tester->assertInstanceOf(Model\TransactionStandard::class, $model);
        $this->tester->assertNotEmpty($html);
        $this->tester->assertSame($this->tester->returnStaticFileFromFixture('TransactionStandard.html'), $html);
    }

    public function testMapModeToDomain()
    {
        $this->tester->assertSame(Gateway::PAYMENT_DOMAIN_SANDBOX, Gateway::mapModeToDomain(Gateway::MODE_SANDBOX));
        $this->tester->assertSame(Gateway::PAYMENT_DOMAIN_SANDBOX, Gateway::mapModeToDomain('sandbox'));
        $this->tester->assertSame(Gateway::PAYMENT_DOMAIN_SANDBOX, Gateway::mapModeToDomain('abcde'));
        $this->tester->assertSame(Gateway::PAYMENT_DOMAIN_LIVE, Gateway::mapModeToDomain(Gateway::MODE_LIVE));
        $this->tester->assertSame(Gateway::PAYMENT_DOMAIN_LIVE, Gateway::mapModeToDomain('live'));
    }

    public function testMapModeToUrl()
    {
        $this->tester->assertSame('https://pay-accept.bm.pl', Gateway::mapModeToUrl(Gateway::MODE_SANDBOX));
        $this->tester->assertSame('https://pay.bm.pl', Gateway::mapModeToUrl(Gateway::MODE_LIVE));
        $this->tester->assertSame('https://pay-accept.bm.pl', Gateway::mapModeToUrl('abcde'));
    }

    public function testGetActionUrl()
    {
        $this->tester->assertSame('https://pay-accept.bm.pl/payment', Gateway::getActionUrl(Gateway::PAYMENT_ACTON_PAYMENT));
        $this->tester->assertSame('https://pay-accept.bm.pl/paywayList', Gateway::getActionUrl(Gateway::PAYMENT_ACTON_PAYWAY_LIST));
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Requested action "abcde" not supported
     * @expectedExceptionCode 0
     */
    public function testGetActionUrlShouldThrowException()
    {
        $this->tester->assertNull(Gateway::getActionUrl('abcde'));
    }

    public function testGenerateHash()
    {
        $this->tester->assertSame('1b830b33a73fc1e232e060e8cf13a2a9fd8579255cc273bfab43f74b50b986dc', Gateway::generateHash(array()));
        $this->tester->assertSame(
            '48f25c4ee1baf9ccc39da479b0ac93a51debadf815aee53711fdd0ab1c227b0a',
            Gateway::generateHash(array(
                'serviceID' => 123456,
                'orderID' => '148104586',
                'confirmation' => 'CONFIRMED',
            ))
        );
        $this->tester->assertSame(
            'c77d1a623087dacfe093285864c5ee835e01a2d781bca697c01c8e21c74950d5',
            Gateway::generateHash(array(
                'serviceID' => 159623,
                'orderID' => '1481064927',
                'hash' => 'somehash',
                'confirmation' => 'NOTCONFIRMED',
            ))
        );
    }

    /**
     * @group PaywayList
     */
    public function testDoPaywayList()
    {
        $httpClient = Stub::make(new HttpClient(), array(
                'post' => Stub::make(\GuzzleHttp\Psr7\Response::class, array(
                        'getStatusCode' => 200,
                        'getBody' => $this->tester->returnStaticFileFromFixture('paywayList.xml'),
                    )),
            ));
        $messageId = '88d5d66ac8579d344154156f286e4da3';
        $this->gateway = Stub::make($this->gateway, array(
            'generateMessageId' => $messageId,
            'httpClient' => $httpClient,
        ));

        /** @var PaywayList\Model $model */
        $model = $this->gateway->doPaywayList();

        $this->tester->assertInstanceOf(PaywayList\Model::class, $model);
        $this->tester->assertSame($this->serviceId, $model->getServiceId());
        $this->tester->assertSame($messageId, $model->getMessageId());
        $this->tester->assertSame('4d4132bb905a40af78914a32ad70f8c9b217d05a045c5ceb6b25db0fc9e49607', $model->getHash());
        $this->tester->assertNotEmpty($model->getGateways());
        $this->tester->assertInternalType('array', $model->getGateways());
        $this->tester->assertCount(7, $model->getGateways());
    }

    /**
     * @group PaywayList
     * @expectedException \RuntimeException
     * @expectedExceptionMessage ERROR
     * @expectedExceptionCode 0
     */
    public function testDoPaywayListShouldThrowException()
    {
        $httpClient = Stub::make(new HttpClient(), array(
                'post' => Stub::make(\GuzzleHttp\Psr7\Response::class, array(
                        'getStatusCode' => 400,
                        'getBody' => $this->tester->returnStaticFileFromFixture('paywayList-Error.xml'),
                    )),
            ));
        $this->gateway = Stub::make($this->gateway, array(
            'httpClient' => $httpClient,
        ));

        /** @var PaywayList\Model $model */
        $model = $this->gateway->doPaywayList();
        $this->tester->assertNull($model);
    }

    public function testGenerateMessageId()
    {
        $messageId = $this->gateway->generateMessageId();
        $this->tester->assertInternalType('string', $messageId);
        $this->tester->assertSame(32, strlen($messageId));

        if (function_exists('mb_strlen')) {
            $this->tester->assertSame(32, mb_strlen($messageId));
        }
    }
}
