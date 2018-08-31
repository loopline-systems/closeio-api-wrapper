<?php

declare(strict_types=1);

/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace Tests\LooplineSystems\CloseIoApiWrapper;

use LooplineSystems\CloseIoApiWrapper\Api\ActivityApi;
use LooplineSystems\CloseIoApiWrapper\Api\CallActivityApi;
use LooplineSystems\CloseIoApiWrapper\Api\ContactApi;
use LooplineSystems\CloseIoApiWrapper\Api\CustomFieldApi;
use LooplineSystems\CloseIoApiWrapper\Api\EmailActivityApi;
use LooplineSystems\CloseIoApiWrapper\Api\LeadApi;
use LooplineSystems\CloseIoApiWrapper\Api\LeadStatusApi;
use LooplineSystems\CloseIoApiWrapper\Api\NoteActivityApi;
use LooplineSystems\CloseIoApiWrapper\Api\OpportunityApi;
use LooplineSystems\CloseIoApiWrapper\Api\OpportunityStatusApi;
use LooplineSystems\CloseIoApiWrapper\Api\SmsActivityApi;
use LooplineSystems\CloseIoApiWrapper\Api\TaskApi;
use LooplineSystems\CloseIoApiWrapper\Api\UserApi;
use LooplineSystems\CloseIoApiWrapper\Client;
use LooplineSystems\CloseIoApiWrapper\CloseIoApiWrapper;
use LooplineSystems\CloseIoApiWrapper\Configuration;

class CloseIoApiWrapperTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var CloseIoApiWrapper
     */
    protected $closeIoApiWrapper;

    protected function setUp()
    {
        $this->client = new Client(new Configuration('foo'));
        $this->closeIoApiWrapper = new CloseIoApiWrapper($this->client);
    }

    public function testItReturnsUserApi()
    {
        $this->assertInstanceOf(UserApi::class, $this->closeIoApiWrapper->getUserApi());
    }

    public function testItReturnsLeadApi()
    {
        $this->assertInstanceOf(LeadApi::class, $this->closeIoApiWrapper->getLeadApi());
    }

    public function testItReturnsCustomFieldApi()
    {
        $this->assertInstanceOf(CustomFieldApi::class, $this->closeIoApiWrapper->getCustomFieldApi());
    }

    public function testItReturnsOpportunityApi()
    {
        $this->assertInstanceOf(OpportunityApi::class, $this->closeIoApiWrapper->getOpportunityApi());
    }

    public function testItReturnsLeadStatusApi()
    {
        $this->assertInstanceOf(LeadStatusApi::class, $this->closeIoApiWrapper->getLeadStatusesApi());
    }

    public function testItReturnsOpportunityStatusApi()
    {
        $this->assertInstanceOf(OpportunityStatusApi::class, $this->closeIoApiWrapper->getOpportunityStatusesApi());
    }

    public function testItReturnsContactApi()
    {
        $this->assertInstanceOf(ContactApi::class, $this->closeIoApiWrapper->getContactApi());
    }

    public function testItReturnsActivityApi()
    {
        $this->assertInstanceOf(ActivityApi::class, $this->closeIoApiWrapper->getActivitiesApi());
    }

    public function testItReturnsCallActivityApi()
    {
        $this->assertInstanceOf(CallActivityApi::class, $this->closeIoApiWrapper->getCallActivitiesApi());
    }

    public function testItReturnsSmsActivityApi()
    {
        $this->assertInstanceOf(SmsActivityApi::class, $this->closeIoApiWrapper->getSmsActivitiesApi());
    }

    public function testItReturnsEmailActivityApi()
    {
        $this->assertInstanceOf(EmailActivityApi::class, $this->closeIoApiWrapper->getEmailActivitiesApi());
    }

    public function testItReturnsNoteActivityApi()
    {
        $this->assertInstanceOf(NoteActivityApi::class, $this->closeIoApiWrapper->getNoteActivitiesApi());
    }

    public function testItReturnsTaskApi()
    {
        $this->assertInstanceOf(TaskApi::class, $this->closeIoApiWrapper->getTaskApi());
    }
}
