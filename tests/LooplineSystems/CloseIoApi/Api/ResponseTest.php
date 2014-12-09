<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper\Tests;

use LooplineSystems\CloseIoApiWrapper\CloseIoResponse;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider jsonErrorResponseProvider
     * @param string $jsonResponse
     */
    public function testResponseErrors($jsonResponse, $expected)
    {
        $response = new CloseIoResponse();
        $response->setData(json_decode($jsonResponse, true));
        if ($expected) {
            $this->assertGreaterThan(0, count($response->getErrors()));
        } else {
            $this->assertEquals(0, count($response->getErrors()));
        }
    }

    /**
     * @return array
     */
    public function jsonErrorResponseProvider()
    {
        return array(
            array('{"error": "The request contains invalid JSON."}', true),
            array('{"errors": [], "field-errors": {"name": "Value must be of basestring type."}}', true),
            array('{"field-errors": {"name": "Value must be of basestring type."}}', true),
            array('{"id": "sample_id", "name": "Test Name"}', false)
        );
    }
}
