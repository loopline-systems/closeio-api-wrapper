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
use LooplineSystems\CloseIoApiWrapper\Model\Address;
use LooplineSystems\CloseIoApiWrapper\Model\Contact;
use LooplineSystems\CloseIoApiWrapper\Model\Email;
use LooplineSystems\CloseIoApiWrapper\Model\Lead;
use LooplineSystems\CloseIoApiWrapper\Api\LeadApi;
use LooplineSystems\CloseIoApiWrapper\Model\Phone;

class LeadsTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateCloseIoWrapper()
    {
        $closeIoConfig = new CloseIoConfig();
        $closeIoConfig->setApiKey('testapikey');
        $closeIoApiWrapper = new CloseIoApiWrapper($closeIoConfig);
        $this->assertTrue(get_class($closeIoApiWrapper) === 'LooplineSystems\CloseIoApiWrapper\CloseIoApiWrapper');
    }

    public function testCreateLeadApi()
    {
        $closeIoConfig = new CloseIoConfig();
        $closeIoConfig->setApiKey('testapikey');
        $closeIoApiWrapper = new CloseIoApiWrapper($closeIoConfig);
        $leadApi = $closeIoApiWrapper->getLeadApi();
        $this->assertTrue(get_class($leadApi) === 'LooplineSystems\CloseIoApiWrapper\Api\LeadApi');
    }
}
