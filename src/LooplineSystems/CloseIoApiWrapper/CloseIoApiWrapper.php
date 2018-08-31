<?php

declare(strict_types=1);

/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

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

    /**
     * @return LeadApi
     */
    public function getLeadApi(): LeadApi
    {
        return $this->leadApi;
    }

    /**
     * @return CustomFieldApi
     */
    public function getCustomFieldApi(): CustomFieldApi
    {
        return $this->customFieldApi;
    }

    /**
     * @return OpportunityApi
     */
    public function getOpportunityApi(): OpportunityApi
    {
        return $this->opportunityApi;
    }

    /**
     * @return LeadStatusApi
     */
    public function getLeadStatusesApi(): LeadStatusApi
    {
        return $this->leadStatusesApi;
    }

    /**
     * @return OpportunityStatusApi
     */
    public function getOpportunityStatusesApi(): OpportunityStatusApi
    {
        return $this->opportunityStatusesApi;
    }

    /**
     * @return ContactApi
     */
    public function getContactApi(): ContactApi
    {
        return $this->contactApi;
    }

    /**
     * @return ActivityApi
     */
    public function getActivitiesApi(): ActivityApi
    {
        return $this->activitiesApi;
    }

    /**
     * @return CallActivityApi
     */
    public function getCallActivitiesApi(): CallActivityApi
    {
        return $this->callActivitiesApi;
    }

    /**
     * @return SmsActivityApi
     */
    public function getSmsActivitiesApi(): SmsActivityApi
    {
        return $this->smsActivitiesApi;
    }

    /**
     * @return EmailActivityApi
     */
    public function getEmailActivitiesApi(): EmailActivityApi
    {
        return $this->emailActivitiesApi;
    }

    /**
     * @return NoteActivityApi
     */
    public function getNoteActivitiesApi(): NoteActivityApi
    {
        return $this->noteActivitiesApi;
    }

    /**
     * @return TaskApi
     */
    public function getTaskApi(): TaskApi
    {
        return $this->taskApi;
    }

    /**
     * @return UserApi
     */
    public function getUserApi(): UserApi
    {
        return $this->userApi;
    }
}
