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

use Symfony\Component\Yaml\Yaml;

define('CLOSE_IO_APP_ROOT', realpath(__DIR__) . '/');

class CloseIoApiWrapper
{

    /**
     * @var ApiHandler
     */
    private $apiHandler;

    /**
     * @param string $env
     */
    public function __construct($env)
    {
        $config = $this->readConfig($env);
        $this->apiHandler = $this->initApiHandler($config);
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
     * @param $env
     * @return array
     * @throws \Exception
     */
    public function readConfig($env)
    {
        $fileNameAbsolute = CLOSE_IO_APP_ROOT . '../../../config/' . $env . '/config';
        return self::parseYml($fileNameAbsolute);
    }

    /**
     * @param $fileName
     * @return array
     * @throws \Exception
     */
    protected function parseYml($fileName)
    {
        $fileName .= '.yml';
        if (!file_exists($fileName)) {
            throw new \Exception($fileName . ' not found');
        }
        return Yaml::parse($fileName);
    }

    /**
     * @return ApiHandler
     */
    public function getApiHandler()
    {
        return $this->apiHandler;
    }
}
