<?php
/**
 */
namespace Cube\Test;

require dirname(__DIR__) . '/vendor/autoload.php';

class CubeTest extends \PHPUnit_Framework_TestCase
{
    public function testCommand()
    {
        $cmds = array('eventGet','metricGet','typesGet','eventPut','collectdPut');
        $this->assertEquals($cmds, \Cube\Command::getCommands());
    }

    /**
     * @dataProvider createHttpClient
     */
    public function testMetric($client)
    {
        // GET http://localhost:1081/1.0/metric?expression=sum(cube_request)&step=6e4&limit=1
        // [{"time":"2013-02-27T19:03:00.000Z","value":0}]

        $res = $client->metricGet(array(
            'expression' => 'sum(cube_request)',
            'step' => \Cube\Client::INT_ONE_MINUTE,
            'limit' => 10,
        ));

        $this->assertInternalType('array', $res);
        $this->assertCount(10, $res);
        $entry = reset($res);
        $this->assertArrayHasKey('time', $entry);
        $this->assertArrayHasKey('value', $entry);
    }

    /**
     * @dataProvider createHttpClient
     */
    public function testTypes($client)
    {
        $res = $client->typesGet();
        $this->assertInternalType('array', $res);
    }

    public function createHttpClient()
    {
        $client = \Cube\Client::createHttpClient(array(
            'host' => 'localhost',
            'port' => 1081,
            'secure' => false,
        ));
        return array(
            array($client),
        );
    }
}
