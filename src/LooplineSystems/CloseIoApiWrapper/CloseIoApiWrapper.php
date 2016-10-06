<?php
/**
* Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
*
* @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
* @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
* @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
*/

namespace LooplineSystems\CloseIoApiWrapper;

use LooplineSystems\CloseIoApiWrapper\Api\ContactApi;
use LooplineSystems\CloseIoApiWrapper\Api\CustomFieldApi;
use LooplineSystems\CloseIoApiWrapper\Api\LeadApi;
use LooplineSystems\CloseIoApiWrapper\Api\LeadStatusApi;
use LooplineSystems\CloseIoApiWrapper\Api\OpportunityApi;
use LooplineSystems\CloseIoApiWrapper\Api\OpportunityStatusApi;
use LooplineSystems\CloseIoApiWrapper\Library\Api\ApiHandler;

define('CLOSE_IO_APP_ROOT', realpath(__DIR__) . '/');

class CloseIoApiWrapper
{

    /**
     * @var ApiHandler
     */
    private $apiHandler;

    /**
     * @param CloseIoConfig $config
     * @throws \Exception
     */
    public function __construct(CloseIoConfig $config)
    {
        if ($config->getApiKey() !== '' && $config->getUrl() !== ''){
            $this->apiHandler = $this->initApiHandler($config);
        } else {
            throw new \Exception('Config must contain url and api key');
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

        return $apiHandler;
    }

    /**
     * @return LeadApi
     * @throws Library\Exception\ApiNotFoundException
     */
    public function getLeadApi()
    {
        return $this->apiHandler->getApi(LeadApi::NAME);
    }

    /**
     * @return CustomFieldApi
     * @throws Library\Exception\ApiNotFoundException
     */
    public function getCustomFieldApi()
    {
        return $this->apiHandler->getApi(CustomFieldApi::NAME);
    }

    /**
     * @return OpportunityApi
     * @throws Library\Exception\ApiNotFoundException
     */
    public function getOpportunityApi()
    {
        return $this->apiHandler->getApi(OpportunityApi::NAME);
    }

    /**
     * @return LeadStatusApi
     * @throws Library\Exception\ApiNotFoundException
     */
    public function getLeadStatusesApi()
    {
        return $this->apiHandler->getApi(LeadStatusApi::NAME);
    }

    /**
     * @return OpportunityStatusApi
     * @throws Library\Exception\ApiNotFoundException
     */
    public function getOpportunityStatusesApi()
    {
        return $this->apiHandler->getApi(OpportunityStatusApi::NAME);
    }

    /**
     * @return Library\Api\AbstractApi
     * @throws Library\Exception\ApiNotFoundException
     */
    public function getContactApi()
    {
        return $this->apiHandler->getApi(ContactApi::NAME);
    }

    /**
     * @return ApiHandler
     */
    public function getApiHandler()
    {
        return $this->apiHandler;
    }
}
