<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace Tests\LooplineSystems\CloseIoApiWrapper;

use LooplineSystems\CloseIoApiWrapper\CloseIoConfig;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;

class CloseIoConfigTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateCloseIoConfigHaveValidUrlByDefault()
    {
        $config = new CloseIoConfig();

        $this->assertNotFalse(filter_var($config->getUrl(), FILTER_VALIDATE_URL));
    }

    /**
     * @param string $key
     * @param string $expected
     *
     * @dataProvider apiKeyProvider()
     */
    public function testCreateCloseIoConfigReturnApiKey($key, $expected)
    {
        $config = new CloseIoConfig();
        $config->setApiKey($key);

        $this->assertEquals($expected, $config->getApiKey());
    }

    public function apiKeyProvider()
    {
        return [
            ['api-key', 'api-key:'],
            ['api-key:', 'api-key:'],
            ['other-key:', 'other-key:'],
        ];
    }

    /**
     * @param mixed $url
     *
     * @dataProvider getBadUrls
     */
    public function testCreateCloseIoConfigGenerateErrorWithInvaludUrl($url)
    {
        $this->expectException(InvalidParamException::class);

        new CloseIoConfig($url);
    }

    /**
     * @return array
     */
    public function getBadUrls()
    {
        return [
            [null],
            [1],
            ['badUrl'],
        ];
    }
}
