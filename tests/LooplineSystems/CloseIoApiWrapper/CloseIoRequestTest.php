<?php declare(strict_types=1);
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace Tests\LooplineSystems\CloseIoApiWrapper;

use LooplineSystems\CloseIoApiWrapper\CloseIoRequest;
use LooplineSystems\CloseIoApiWrapper\CloseIoConfig;
use LooplineSystems\CloseIoApiWrapper\Library\Api\ApiHandler;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;

class CloseIoRequestTest extends \PHPUnit\Framework\TestCase
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

        $this->assertInstanceOf(CloseIoRequest::class, $request);
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

        $this->assertContains('Accept: application/json', $headers);
        $this->assertContains('Content-Type: application/json', $headers);
    }

    /**
     * @param mixed $data
     * @param string $expectedData
     *
     * @dataProvider validJSONStringProvider
     * @throws InvalidParamException
     */
    public function testValidJSONData($data, $expectedData)
    {
        $closeIoConfig = new CloseIoConfig();
        $closeIoConfig->setApiKey('testapikey');
        $closeIoApiHandler = new ApiHandler($closeIoConfig);
        $request = new CloseIoRequest($closeIoApiHandler);

        $request->setData($data);
        $this->assertEquals($expectedData, $request->getData());
    }

    /**
     * @return array
     */
    public function validJSONStringProvider()
    {
        return [
            [[], []],
            [2, 2],
            [2.1, 2.1],
            [null, null],
            [true, true],
            [false, false],
            ['{"Value": "This is valid JSON."}', ['Value' => 'This is valid JSON.']],
            [
                '{"Value": [], "Value Two": {"name": "This is also valid"}}',
                ["Value" => [], 'Value Two' => ['name' => 'This is also valid']]
            ],
            [['this is an array, not json at all!'], ['this is an array, not json at all!']],
            ['"I\'m a json string"', 'I\'m a json string']
        ];
    }

    /**
     * @param mixed $data
     *
     * @dataProvider brokenJSONStringProvider
     * @throws InvalidParamException
     */
    public function testBrokenJSONData($data)
    {
        $closeIoConfig = new CloseIoConfig();
        $closeIoConfig->setApiKey('testapikey');
        $closeIoApiHandler = new ApiHandler($closeIoConfig);
        $request = new CloseIoRequest($closeIoApiHandler);

        $this->expectException(InvalidParamException::class);
        $request->setData($data);
    }

    /**
     * @return array
     */
    public function brokenJSONStringProvider()
    {
        return [
            [new \stdClass(), false],
            ['{"Problem: {"name": "This time problem is missing a closing quotation mark"}}'],
        ];
    }
}
