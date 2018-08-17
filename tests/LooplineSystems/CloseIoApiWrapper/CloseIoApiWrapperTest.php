<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace Tests\LooplineSystems\CloseIoApiWrapper;

use LooplineSystems\CloseIoApiWrapper\Api\ActivityApi;
use LooplineSystems\CloseIoApiWrapper\Api\ContactApi;
use LooplineSystems\CloseIoApiWrapper\Api\CustomFieldApi;
use LooplineSystems\CloseIoApiWrapper\Api\LeadApi;
use LooplineSystems\CloseIoApiWrapper\Api\LeadStatusApi;
use LooplineSystems\CloseIoApiWrapper\Api\OpportunityApi;
use LooplineSystems\CloseIoApiWrapper\Api\OpportunityStatusApi;
use LooplineSystems\CloseIoApiWrapper\Api\TaskApi;
use LooplineSystems\CloseIoApiWrapper\Api\UserApi;
use LooplineSystems\CloseIoApiWrapper\CloseIoApiWrapper;
use LooplineSystems\CloseIoApiWrapper\CloseIoConfig;

class CloseIoApiWrapperTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateCloseIoWrapper()
    {
        $config = new CloseIoConfig();
        $config->setApiKey('testkey');
        $closeIoApiWrapper = new CloseIoApiWrapper($config);

        $this->assertInstanceOf(CloseIoApiWrapper::class, $closeIoApiWrapper);
    }

    public function testItReturnsUserApi()
    {
        $config = new CloseIoConfig();
        $config->setApiKey('testkey');
        $closeIoApiWrapper = new CloseIoApiWrapper($config);

        $this->assertInstanceOf(UserApi::class, $closeIoApiWrapper->getUserApi());
    }

    public function testItReturnsLeadApi()
    {
        $config = new CloseIoConfig();
        $config->setApiKey('testkey');
        $closeIoApiWrapper = new CloseIoApiWrapper($config);

        $this->assertInstanceOf(LeadApi::class, $closeIoApiWrapper->getLeadApi());
    }

    public function testItReturnsCustomFieldApi()
    {
        $config = new CloseIoConfig();
        $config->setApiKey('testkey');
        $closeIoApiWrapper = new CloseIoApiWrapper($config);

        $this->assertInstanceOf(CustomFieldApi::class, $closeIoApiWrapper->getCustomFieldApi());
    }

    public function testItReturnsOpportunityApi()
    {
        $config = new CloseIoConfig();
        $config->setApiKey('testkey');
        $closeIoApiWrapper = new CloseIoApiWrapper($config);

        $this->assertInstanceOf(OpportunityApi::class, $closeIoApiWrapper->getOpportunityApi());
    }

    public function testItReturnsLeadStatusApi()
    {
        $config = new CloseIoConfig();
        $config->setApiKey('testkey');
        $closeIoApiWrapper = new CloseIoApiWrapper($config);

        $this->assertInstanceOf(LeadStatusApi::class, $closeIoApiWrapper->getLeadStatusesApi());
    }

    public function testItReturnsOpportunityStatusApi()
    {
        $config = new CloseIoConfig();
        $config->setApiKey('testkey');
        $closeIoApiWrapper = new CloseIoApiWrapper($config);

        $this->assertInstanceOf(OpportunityStatusApi::class, $closeIoApiWrapper->getOpportunityStatusesApi());
    }

    public function testItReturnsContactApi()
    {
        $config = new CloseIoConfig();
        $config->setApiKey('testkey');
        $closeIoApiWrapper = new CloseIoApiWrapper($config);

        $this->assertInstanceOf(ContactApi::class, $closeIoApiWrapper->getContactApi());
    }

    public function testItReturnsActivityApi()
    {
        $config = new CloseIoConfig();
        $config->setApiKey('testkey');
        $closeIoApiWrapper = new CloseIoApiWrapper($config);

        $this->assertInstanceOf(ActivityApi::class, $closeIoApiWrapper->getActivitiesApi());
    }

    public function testItReturnsTaskApi()
    {
        $config = new CloseIoConfig();
        $config->setApiKey('testkey');
        $closeIoApiWrapper = new CloseIoApiWrapper($config);

        $this->assertInstanceOf(TaskApi::class, $closeIoApiWrapper->getTaskApi());
    }

}
