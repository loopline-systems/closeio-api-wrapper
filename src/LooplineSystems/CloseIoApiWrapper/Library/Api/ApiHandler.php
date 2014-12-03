<?php
/**
* Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
*
* @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
* @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
* @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
*/

namespace LooplineSystems\CloseIoApiWrapper\Library\Api;

use LooplineSystems\CloseIoApiWrapper\Library\Exception\ApiNotFoundException;

class ApiHandler
{
    const CONFIG_API_KEY = 'api_key';
    const CONFIG_URL = 'url';

    /**
     * @var array
     */
    private $config;

    /**
     * @var array
     */
    private $apis;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param $api
     */
    public function setApi(ApiInterface $api)
    {
        $this->apis[$api->getName()] = $api;
    }

    /**
     * @param $name
     * @return AbstractApi
     * @throws ApiNotFoundException
     */
    public function getApi($name)
    {
        if (isset($this->apis[$name])) {
            return $this->apis[$name];
        } else {
            throw new ApiNotFoundException($name);
        }
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }
}
