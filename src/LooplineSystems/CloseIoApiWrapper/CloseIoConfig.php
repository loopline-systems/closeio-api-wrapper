<?php
/**
* Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
*
* @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
* @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
* @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
*/

namespace LooplineSystems\CloseIoApiWrapper;

use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;

class CloseIoConfig
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @param string $url
     */
    public function __construct($url = 'https://app.close.io/api/v1')
    {
        $this->setUrl($url);
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        if ($apiKey && substr($apiKey, -1) !== ':'){
            $apiKey = $apiKey . ':';
        }
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @throws InvalidParamException
     */
    public function setUrl($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $this->url = $url;
        } else {
            throw new InvalidParamException('Api Url must be valid url');
        }
    }
}
