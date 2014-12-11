<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper\Tests;

use LooplineSystems\CloseIoApiWrapper\CloseIoApiWrapper;
use LooplineSystems\CloseIoApiWrapper\CloseIoConfig;

class WrapperTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateCloseIoWrapper()
    {
        $config = new CloseIoConfig();
        $config->setApiKey('testkey');
        $closeIoApiWrapper = new CloseIoApiWrapper($config);
        $this->assertTrue(get_class($closeIoApiWrapper) === 'LooplineSystems\CloseIoApiWrapper\CloseIoApiWrapper');
    }
}
