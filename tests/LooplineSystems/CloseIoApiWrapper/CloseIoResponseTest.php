<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace Tests\LooplineSystems\CloseIoApiWrapper;

use LooplineSystems\CloseIoApiWrapper\CloseIoResponse;

class CloseIoResponseTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @param string $jsonResponse
     *
     * @dataProvider jsonErrorResponseProvider
     */
    public function testResponseErrors($jsonResponse)
    {
        $response = new CloseIoResponse();
        $response->setData(json_decode($jsonResponse, true));

        $this->assertGreaterThan(0, count($response->getErrors()));
    }

    /**
     * @return array
     */
    public function jsonErrorResponseProvider()
    {
        return [
            ['{"error": "The request contains invalid JSON."}'],
            ['{"errors": [], "field-errors": {"name": "Value must be of basestring type."}}'],
            ['{"field-errors": {"name": "Value must be of basestring type."}}'],
        ];
    }

    /**
     * @param string $jsonResponse
     *
     * @dataProvider jsonResponseProvider
     */
    public function testResponseWithoutErrors($jsonResponse)
    {
        $response = new CloseIoResponse();
        $response->setData(json_decode($jsonResponse, true));

        $this->assertEquals(0, count($response->getErrors()));
    }

    /**
     * @return array
     */
    public function jsonResponseProvider()
    {
        return [
            ['{"id": "sample_id", "name": "Test Name"}']
        ];
    }
}
