<?php

namespace BlueMedia\OnlinePayments\Tests\Unit\Action\ITN;

use BlueMedia\OnlinePayments\Action\ITN\Transformer;
use BlueMedia\OnlinePayments\Util\XMLParser;

class TransformerTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var Transformer
     */
    protected $transformer;

    protected function _before()
    {
        $this->transformer = new Transformer();
    }

    protected function _after()
    {
        unset($this->transformer);
    }

    public function testModelToArray()
    {
        $array = $this->transformer->modelToArray($this->tester->returnPhpFileFromFixture('ItnIn-Full-Card.php'));

        $cData = $array['customerData'];
        $this->tester->assertSame('Jan', $cData['fName']);
        $this->tester->assertSame('Kowalski', $cData['lName']);
        $this->tester->assertSame('Jasna', $cData['streetName']);
        $this->tester->assertSame('6', $cData['streetHouseNo']);
        $this->tester->assertSame('A', $cData['streetStaircaseNo']);
        $this->tester->assertSame('3', $cData['streetPremiseNo']);
        $this->tester->assertSame('10-234', $cData['postalCode']);
        $this->tester->assertSame('Warszawa', $cData['city']);
        $this->tester->assertSame('26105014451000002276470461', $cData['nrb']);
        $this->tester->assertSame('Jan Kowalski Jasna 6/A/3 10-234 Warszawa', $cData['senderData']);

        $this->tester->assertSame('INIT_WITH_PAYMENT', $array['recurringData']['recurringAction']);
        $this->tester->assertSame('2SVrtcq1o10CI8bUSlBAZq2QlXZDT27C63c6XOg0j70UqyyH5nlkWt30LeDnSDgw', $array['recurringData']['clientHash']);

        $this->tester->assertSame('EYmvH7VTeJti5Y70qqZw83OKtnb8tGmU72rUw8gWRU0dP2ZSTWiNnTD3OyJrUSwC', $array['cardData']['index']);
        $this->tester->assertSame('2024', $array['cardData']['validityYear']);
        $this->tester->assertSame('06', $array['cardData']['validityMonth']);
        $this->tester->assertSame('MASTERCARD', $array['cardData']['issuer']);
        $this->tester->assertSame('510010', $array['cardData']['bin']);
        $this->tester->assertSame('0000', $array['cardData']['mask']);

        $this->tester->assertSame(100660, $array['serviceID']);
        $this->tester->assertSame('1481064927', $array['orderID']);
        $this->tester->assertSame('96JMSU8K', $array['remoteID']);
        $this->tester->assertSame('9877.54', $array['amount']);
        $this->tester->assertSame('PLN', $array['currency']);
        $this->tester->assertSame(1500, $array['gatewayID']);
        $this->tester->assertSame('20161206235539', $array['paymentDate']);
        $this->tester->assertSame('SUCCESS', $array['paymentStatus']);
        $this->tester->assertSame('AUTHORIZED', $array['paymentStatusDetails']);
        $this->tester->assertSame('FV 2016/12/5/454677789', $array['invoiceNumber']);
        $this->tester->assertSame('12', $array['customerNumber']);
        $this->tester->assertSame('piotr@zuralski.net', $array['customerEmail']);
        $this->tester->assertSame('192.168.0.34', $array['addressIP']);
        $this->tester->assertSame('POSITIVE', $array['verificationStatus']);
        $this->tester->assertSame(9876.54, $array['startAmount']);
        $this->tester->assertSame('20160110080000', $array['transferDate']);
        $this->tester->assertSame('SUCCESS', $array['transferStatus']);
        $this->tester->assertSame('CONFIRMED', $array['transferStatusDetails']);
        $this->tester->assertSame('BPID:96JMSU8K Test transaction', $array['title']);
        $this->tester->assertSame('mBank S.A.', $array['receiverBank']);
        $this->tester->assertSame('PL40114020040000350276811499', $array['receiverNRB']);
        $this->tester->assertSame('Zuralski.net', $array['receiverName']);
        $this->tester->assertSame('Gdańsk', $array['receiverAddress']);
        $this->tester->assertSame('mBank S.A.', $array['senderBank']);
        $this->tester->assertSame('57114020040000300234463178', $array['senderNRB']);
        $this->tester->assertSame('fc787a482e9bd0f707223de3c687a96f3f9a3ed8922d8291a5dfc061a997fb20', $array['Hash']);
    }

    public function testToModel()
    {
        $simpleXml = XMLParser::parse($this->tester->returnStaticFileFromFixture('ItnIn-Full-Card.xml'));
        $model = $this->transformer->toModel($simpleXml);
        $this->tester->assertEquals($this->tester->returnPhpFileFromFixture('ItnIn-Full-Card.php'), $model);
    }
}
