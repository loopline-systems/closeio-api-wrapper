<?php

/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems.
 *
 * @see      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 *
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

declare(strict_types=1);

namespace LooplineSystems\CloseIoApiWrapper;

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

class CloseIoApiWrapper
{
    /**
     * @var LeadApi
     */
    private $leadApi;

    /**
     * @var OpportunityApi
     */
    private $opportunityApi;

    /**
     * @var LeadStatusApi
     */
    private $leadStatusesApi;

    /**
     * @var OpportunityStatusApi
     */
    private $opportunityStatusesApi;

    /**
     * @var CustomFieldApi
     */
    private $customFieldApi;

    /**
     * @var ContactApi
     */
    private $contactApi;

    /**
     * @var ActivityApi
     */
    private $activitiesApi;

    /**
     * @var CallActivityApi
     */
    private $callActivitiesApi;

    /**
     * @var SmsActivityApi
     */
    private $smsActivitiesApi;

    /**
     * @var EmailActivityApi
     */
    private $emailActivitiesApi;

    /**
     * @var NoteActivityApi
     */
    private $noteActivitiesApi;

    /**
     * @var TaskApi
     */
    private $taskApi;

    /**
     * @var UserApi
     */
    private $userApi;

    public function __construct(Client $client)
    {
        $this->leadApi = new LeadApi($client);
        $this->opportunityApi = new OpportunityApi($client);
        $this->leadStatusesApi = new LeadStatusApi($client);
        $this->opportunityStatusesApi = new OpportunityStatusApi($client);
        $this->customFieldApi = new CustomFieldApi($client);
        $this->contactApi = new ContactApi($client);
        $this->activitiesApi = new ActivityApi($client, $this);
        $this->callActivitiesApi = new CallActivityApi($client);
        $this->smsActivitiesApi = new SmsActivityApi($client);
        $this->emailActivitiesApi = new EmailActivityApi($client);
        $this->noteActivitiesApi = new NoteActivityApi($client);
        $this->taskApi = new TaskApi($client);
        $this->userApi = new UserApi($client);
    }

    public function getLeadApi(): LeadApi
    {
        return $this->leadApi;
    }

    public function getCustomFieldApi(): CustomFieldApi
    {
        return $this->customFieldApi;
    }

    public function getOpportunityApi(): OpportunityApi
    {
        return $this->opportunityApi;
    }

    public function getLeadStatusesApi(): LeadStatusApi
    {
        return $this->leadStatusesApi;
    }

    public function getOpportunityStatusesApi(): OpportunityStatusApi
    {
        return $this->opportunityStatusesApi;
    }

    public function getContactApi(): ContactApi
    {
        return $this->contactApi;
    }

    public function getActivitiesApi(): ActivityApi
    {
        return $this->activitiesApi;
    }

    public function getCallActivitiesApi(): CallActivityApi
    {
        return $this->callActivitiesApi;
    }

    public function getSmsActivitiesApi(): SmsActivityApi
    {
        return $this->smsActivitiesApi;
    }

    public function getEmailActivitiesApi(): EmailActivityApi
    {
        return $this->emailActivitiesApi;
    }

    public function getNoteActivitiesApi(): NoteActivityApi
    {
        return $this->noteActivitiesApi;
    }

    public function getTaskApi(): TaskApi
    {
        return $this->taskApi;
    }

    public function getUserApi(): UserApi
    {
        return $this->userApi;
    }
}
