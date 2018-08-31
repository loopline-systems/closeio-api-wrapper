<?php declare(strict_types=1);
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
use LooplineSystems\CloseIoApiWrapper\Configuration;

class CloseIoApiWrapperTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateCloseIoWrapper()
    {
        $closeIoApiWrapper = new CloseIoApiWrapper(new Configuration(['api_key' => 'foo']));

        $this->assertInstanceOf(CloseIoApiWrapper::class, $closeIoApiWrapper);
    }

    public function testItReturnsUserApi()
    {
        $closeIoApiWrapper = new CloseIoApiWrapper(new Configuration(['api_key' => 'foo']));

        $this->assertInstanceOf(UserApi::class, $closeIoApiWrapper->getUserApi());
    }

    public function testItReturnsLeadApi()
    {
        $closeIoApiWrapper = new CloseIoApiWrapper(new Configuration(['api_key' => 'foo']));

        $this->assertInstanceOf(LeadApi::class, $closeIoApiWrapper->getLeadApi());
    }

    public function testItReturnsCustomFieldApi()
    {
        $closeIoApiWrapper = new CloseIoApiWrapper(new Configuration(['api_key' => 'foo']));

        $this->assertInstanceOf(CustomFieldApi::class, $closeIoApiWrapper->getCustomFieldApi());
    }

    public function testItReturnsOpportunityApi()
    {
        $closeIoApiWrapper = new CloseIoApiWrapper(new Configuration(['api_key' => 'foo']));

        $this->assertInstanceOf(OpportunityApi::class, $closeIoApiWrapper->getOpportunityApi());
    }

    public function testItReturnsLeadStatusApi()
    {
        $closeIoApiWrapper = new CloseIoApiWrapper(new Configuration(['api_key' => 'foo']));

        $this->assertInstanceOf(LeadStatusApi::class, $closeIoApiWrapper->getLeadStatusesApi());
    }

    public function testItReturnsOpportunityStatusApi()
    {
        $closeIoApiWrapper = new CloseIoApiWrapper(new Configuration(['api_key' => 'foo']));

        $this->assertInstanceOf(OpportunityStatusApi::class, $closeIoApiWrapper->getOpportunityStatusesApi());
    }

    public function testItReturnsContactApi()
    {
        $closeIoApiWrapper = new CloseIoApiWrapper(new Configuration(['api_key' => 'foo']));

        $this->assertInstanceOf(ContactApi::class, $closeIoApiWrapper->getContactApi());
    }

    public function testItReturnsActivityApi()
    {
        $closeIoApiWrapper = new CloseIoApiWrapper(new Configuration(['api_key' => 'foo']));

        $this->assertInstanceOf(ActivityApi::class, $closeIoApiWrapper->getActivitiesApi());
    }

    public function testItReturnsTaskApi()
    {
        $closeIoApiWrapper = new CloseIoApiWrapper(new Configuration(['api_key' => 'foo']));

        $this->assertInstanceOf(TaskApi::class, $closeIoApiWrapper->getTaskApi());
    }

}
