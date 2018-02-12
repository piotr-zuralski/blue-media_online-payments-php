<?php

namespace BlueMedia\OnlinePayments\Tests\Unit\Action\PaywayList;

use BlueMedia\OnlinePayments\Action\PaywayList\Transformer;
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

    // tests
    public function testModelToArray()
    {
        $array = $this->transformer->modelToArray($this->tester->returnPhpFileFromFixture('paywayList-short.php'));

        $this->tester->assertSame(123456, $array['serviceID']);
        $this->tester->assertSame('88d5d66ac8579d344154156f286e4da3', $array['messageID']);
        $this->tester->assertSame('4d4132bb905a40af78914a32ad70f8c9b217d05a045c5ceb6b25db0fc9e49607', $array['hash']);

        $this->tester->assertSame(106, $array['gateway'][0]['gatewayID']);
        $this->tester->assertSame('PG płatność testowa', $array['gateway'][0]['gatewayName']);
        $this->tester->assertSame('PBL', $array['gateway'][0]['gatewayType']);
        $this->tester->assertSame('NONE', $array['gateway'][0]['bankName']);
        $this->tester->assertSame('https://platnosci.bm.pl/pomoc/grafika/106.gif', $array['gateway'][0]['iconURL']);
        $this->tester->assertSame('2017-08-29 11:42:05', $array['gateway'][0]['statusDate']);

        $this->tester->assertSame(21, $array['gateway'][1]['gatewayID']);
        $this->tester->assertSame('Przelew Volkswagen Bank', $array['gateway'][1]['gatewayName']);
        $this->tester->assertSame('Szybki przelew', $array['gateway'][1]['gatewayType']);
        $this->tester->assertSame('NONE', $array['gateway'][1]['bankName']);
        $this->tester->assertSame('https://platnosci.bm.pl/pomoc/grafika/21.gif', $array['gateway'][1]['iconURL']);
        $this->tester->assertSame('2017-08-29 11:42:05', $array['gateway'][1]['statusDate']);
    }

    public function testToModel()
    {
        $simpleXml = XMLParser::parse($this->tester->returnStaticFileFromFixture('paywayList-short.xml'));
        $model = $this->transformer->toModel($simpleXml);
        $this->tester->assertEquals($this->tester->returnPhpFileFromFixture('paywayList-short.php'), $model);
    }
}
