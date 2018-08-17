<?php declare(strict_types=1);
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper\Library\Api;

use LooplineSystems\CloseIoApiWrapper\CloseIoConfig;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\ApiNotFoundException;

class ApiHandler
{
    /**
     * @var CloseIoConfig
     */
    private $config;

    /**
     * @var array
     */
    private $apis;

    /**
     * @param CloseIoConfig $config
     */
    public function __construct(CloseIoConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param ApiInterface $api
     */
    public function setApi(ApiInterface $api)
    {
        $this->apis[$api->getName()] = $api;
    }

    /**
     * @param string $name
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
     * @return CloseIoConfig
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return ApiInterface[]
     */
    public function getApis()
    {
        return $this->apis;
    }
}
