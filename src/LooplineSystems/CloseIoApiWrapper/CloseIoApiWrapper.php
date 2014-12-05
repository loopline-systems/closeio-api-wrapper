<?php
/**
* Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
*
* @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
* @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
* @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
*/

namespace LooplineSystems\CloseIoApiWrapper;

use LooplineSystems\CloseIoApiWrapper\Api\LeadApi;
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
            $this->apiHandler = $this->initApiHandler($config->toArray());
        } else {
            throw new \Exception('Config must contain url and api key');
        }
    }

    /**
     * @param array $config
     * @return ApiHandler
     */
    protected function initApiHandler(array $config)
    {
        $apiHandler = new ApiHandler($config);
        $apiHandler->setApi(new LeadApi($apiHandler));

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
     * @return ApiHandler
     */
    public function getApiHandler()
    {
        return $this->apiHandler;
    }
}
