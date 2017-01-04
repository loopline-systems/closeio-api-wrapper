<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper\Tests;

use LooplineSystems\CloseIoApiWrapper\CloseIoConfig;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $url
     * @param string $apiKey
     * @param bool $expected
     * @dataProvider configProvider
     * @throws InvalidParamException
     */
    public function testCreateCloseIoConfig($url, $apiKey, $expected)
    {
        if ($expected === true) {
            if ($url === null) {
                $closeIoConfig = new closeIoConfig();
            } else {
                $closeIoConfig = new closeIoConfig($url);
            }
            $closeIoConfig->setApiKey($apiKey);
            $this->assertNotFalse(filter_var($closeIoConfig->getUrl(), FILTER_VALIDATE_URL));
            $this->assertTrue($closeIoConfig->getApiKey() != '' && is_string($closeIoConfig->getApiKey()));
        } else if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $this->expectException(InvalidParamException::class);
            new CloseIoConfig($url);
        } else {
            $closeIoConfig = new CloseIoConfig($url);
            $closeIoConfig->setApiKey($apiKey);
            $this->assertNull($closeIoConfig->getApiKey());
        }
    }

    /**
     * @return array
     */
    public function configProvider()
    {
        return array(
            array('https://www.close.io/api/v1', 'test-api-key', true),
            array(null, 'test-api-key', true),
            array('https://www.close.io/api/v1', null, false),
            array('badUrl', 'test-api-key', false),
            array(null, null, false)
        );
    }
}
