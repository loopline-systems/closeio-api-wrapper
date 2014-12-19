<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper\Tests;

use LooplineSystems\CloseIoApiWrapper\CloseIoRequest;
use LooplineSystems\CloseIoApiWrapper\CloseIoApiWrapper;
use LooplineSystems\CloseIoApiWrapper\CloseIoConfig;
use LooplineSystems\CloseIoApiWrapper\Library\Curl\Curl;


class CurlTest extends \PHPUnit_Framework_TestCase
{
    public function testGetResponse()
    {
        $config = new CloseIoConfig();
        $config->setApiKey('testkey');
        $closeIoApiWrapper = new CloseIoApiWrapper($config);

        $curl = new Curl();

        $request = new CloseIoRequest($closeIoApiWrapper->getApiHandler());
        $request->setUrl('www.google.com');
        $request->setMethod(Curl::METHOD_GET);
        $response = $curl->getResponse($request);
        $response =  $curl->getResponse($request);
        $this->assertEquals($response->getReturnCode(), '200');
        $this->assertNotEmpty($response->getRawData());
        $this->assertFalse($response->hasErrors());
    }

    public function testBadRequest()
    {
        $config = new CloseIoConfig();
        $config->setApiKey('testkey');
        $closeIoApiWrapper = new CloseIoApiWrapper($config);

        $leadApi = $closeIoApiWrapper->getLeadApi();

        $this->setExpectedException('LooplineSystems\CloseIoApiWrapper\Library\Exception\BadApiRequestException');

        $leadApi->getLead('bad-id');
    }

    public function testInterface()
    {
        $this->assertTrue(Curl::METHOD_GET === 'GET');
        $this->assertTrue(Curl::METHOD_PUT === 'PUT');
        $this->assertTrue(Curl::METHOD_PATCH === 'PATCH');
        $this->assertTrue(Curl::METHOD_DELETE === 'DELETE');
        $this->assertTrue(Curl::METHOD_POST === 'POST');
    }
}
