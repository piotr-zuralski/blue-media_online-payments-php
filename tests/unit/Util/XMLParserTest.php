<?php

namespace BlueMedia\OnlinePayments\Tests\Unit\Util;

use BlueMedia\OnlinePayments\Util\XMLParser;

class XMLParserTest extends \Codeception\Test\Unit
{

    /** @var string */
    private $fixturesDir = '';

    public function _before()
    {
        $this->fixturesDir = codecept_root_dir('tests/_fixtures/');
    }

    public function testParseShouldReturnObject()
    {
        $xmlContent = file_get_contents($this->fixturesDir . 'XMLParser-valid.xml');
        $result = XMLParser::parse($xmlContent);

        $jsonContent = file_get_contents($this->fixturesDir . 'XMLParser-valid.json');
        $this->tester->assertSame($jsonContent, json_encode($result));
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage String could not be parsed as XML
     * @expectedExceptionCode 0
     */
    public function testParseShouldThrowException()
    {
        $xmlContent = file_get_contents($this->fixturesDir . 'XMLParser-invalid.xml');
        $result = XMLParser::parse($xmlContent);
        $this->tester->assertNull('', $result);
    }
}
