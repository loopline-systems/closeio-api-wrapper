<?php declare(strict_types=1);
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper;

use LooplineSystems\CloseIoApiWrapper\Api\ActivityApi;
use LooplineSystems\CloseIoApiWrapper\Api\ContactApi;
use LooplineSystems\CloseIoApiWrapper\Api\CustomFieldApi;
use LooplineSystems\CloseIoApiWrapper\Api\LeadApi;
use LooplineSystems\CloseIoApiWrapper\Api\LeadStatusApi;
use LooplineSystems\CloseIoApiWrapper\Api\OpportunityApi;
use LooplineSystems\CloseIoApiWrapper\Api\OpportunityStatusApi;
use LooplineSystems\CloseIoApiWrapper\Api\TaskApi;
use LooplineSystems\CloseIoApiWrapper\Api\UserApi;
use LooplineSystems\CloseIoApiWrapper\Library\Api\ApiHandler;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\ApiNotFoundException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;

class CloseIoApiWrapper
{

    /**
     * @var ApiHandler
     */
    private $apiHandler;

    /**
     * @param CloseIoConfig $config
     */
    public function __construct(CloseIoConfig $config)
    {
        $this->apiHandler = $this->initApiHandler($config);

        if ($config->getApiKey() === '' || $config->getUrl() === ''){
            throw new InvalidParamException('Config must contain url and api key');
        }
    }

    /**
     * @param CloseIoConfig $config
     * @return ApiHandler
     */
    protected function initApiHandler(CloseIoConfig $config)
    {
        $apiHandler = new ApiHandler($config);
        $apiHandler->setApi(new LeadApi($apiHandler));
        $apiHandler->setApi(new OpportunityApi($apiHandler));
        $apiHandler->setApi(new LeadStatusApi($apiHandler));
        $apiHandler->setApi(new OpportunityStatusApi($apiHandler));
        $apiHandler->setApi(new CustomFieldApi($apiHandler));
        $apiHandler->setApi(new ContactApi($apiHandler));
        $apiHandler->setApi(new ActivityApi($apiHandler));
        $apiHandler->setApi(new TaskApi($apiHandler));
        $apiHandler->setApi(new UserApi($apiHandler));

        return $apiHandler;
    }

    /**
     * @return LeadApi
     */
    public function getLeadApi()
    {
        /** @var LeadApi $api */
        $api = $this->apiHandler->getApi(LeadApi::NAME);

        return $api;
    }

    /**
     * @return CustomFieldApi
     */
    public function getCustomFieldApi()
    {
        /** @var CustomFieldApi $api */
        $api = $this->apiHandler->getApi(CustomFieldApi::NAME);

        return $api;
    }

    /**
     * @return OpportunityApi
     */
    public function getOpportunityApi()
    {
        /** @var OpportunityApi $api */
        $api = $this->apiHandler->getApi(OpportunityApi::NAME);

        return $api;
    }

    /**
     * @return LeadStatusApi
     */
    public function getLeadStatusesApi()
    {
        /** @var LeadStatusApi $api */
        $api = $this->apiHandler->getApi(LeadStatusApi::NAME);

        return $api;
    }

    /**
     * @return OpportunityStatusApi
     */
    public function getOpportunityStatusesApi()
    {
        /** @var OpportunityStatusApi $api */
        $api = $this->apiHandler->getApi(OpportunityStatusApi::NAME);

        return $api;
    }

    /**
     * @return ContactApi
     */
    public function getContactApi()
    {
        /** @var ContactApi $api */
        $api = $this->apiHandler->getApi(ContactApi::NAME);

        return $api;
    }

    /**
     * @return ActivityApi
     */
    public function getActivitiesApi()
    {
        /** @var ActivityApi $api */
        $api = $this->apiHandler->getApi(ActivityApi::NAME);

        return $api;
    }

    /**
     * @return TaskApi
     */
    public function getTaskApi()
    {
        /** @var TaskApi $api */
        $api = $this->apiHandler->getApi(TaskApi::NAME);

        return $api;
    }

    /**
     * @return ApiHandler
     */
    public function getApiHandler()
    {
        return $this->apiHandler;
    }

    /**
     * @return UserApi
     * @throws Library\Exception\ApiNotFoundException
     */
    public function getUserApi()
    {
        /** @var UserApi $api */
        $api = $this->apiHandler->getApi(UserApi::NAME);

        return $api;
    }
}
