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
use LooplineSystems\CloseIoApiWrapper\CloseIoConfig;
use LooplineSystems\CloseIoApiWrapper\Library\Api\ApiHandler;

class RequestTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @description testing basic initialization
     */
    public function testCreate()
    {
        $closeIoConfig = new CloseIoConfig();
        $closeIoConfig->setApiKey('testapikey');
        $closeIoApiHandler = new ApiHandler($closeIoConfig);
        $request = new CloseIoRequest($closeIoApiHandler);

        $this->assertTrue(get_class($request) === 'LooplineSystems\CloseIoApiWrapper\CloseIoRequest');
    }

    /**
     * @description test that 'accept' and 'content type' headers match json format
     */
    public function testHeadersAreJson()
    {
        $closeIoConfig = new CloseIoConfig();
        $closeIoConfig->setApiKey('testapikey');
        $closeIoApiHandler = new ApiHandler($closeIoConfig);
        $request = new CloseIoRequest($closeIoApiHandler);

        $headers = $request->getHeaders();

        foreach ($headers as $header){
            if (strpos($header, 'Accept:') !== false){
                $this->assertTrue($header === 'Accept: application/json');
            } elseif (strpos($header, 'Content-Type:') !== false){
                $this->assertTrue($header === 'Content-Type: application/json');
            }
        }
    }

    /**
     * @param $jsonString
     * @param $expected
     * @dataProvider jsonStringProvider
     * @throws \LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException
     */
    public function testSetData($jsonString, $expected)
    {
        $closeIoConfig = new CloseIoConfig();
        $closeIoConfig->setApiKey('testapikey');
        $closeIoApiHandler = new ApiHandler($closeIoConfig);
        $request = new CloseIoRequest($closeIoApiHandler);

        if ($expected === false) {
            $this->setExpectedException('LooplineSystems\CloseIoApiWrapper\Library\Exception\JsonDecodingException');
            $request->setData($jsonString);
        } else {
            $request->setData($jsonString);
            $this->assertNotEmpty($request->getData());
        }
    }

    /**
     * @return array
     */
    public function jsonStringProvider()
    {
        return array(
            array('{"Value": "This is valid JSON."}', true),
            array('{"Value": [], "Value Two": {"name": "This is also valid"}}', true),
            array('{"Problem: {"name": "This time problem is missing a closing quotation mark"}}', false),
            array(array('this is an array, not json at all!'), false),
            array('I\'m just a string', false)
        );
    }
}
