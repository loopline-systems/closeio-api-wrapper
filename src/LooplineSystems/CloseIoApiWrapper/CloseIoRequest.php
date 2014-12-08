<?php
/**
* Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
*
* @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
* @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
* @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
*/

namespace LooplineSystems\CloseIoApiWrapper;

use LooplineSystems\CloseIoApiWrapper\Library\Api\ApiHandler;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\JsonDecodingException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;

class CloseIoRequest
{
    const HEADER_ACCEPT_TYPE = 'Accept: ';
    const HEADER_CONTENT_TYPE = 'Content-Type: ';
    const HEADER_MIME_TYPE = 'application/json';

    /**
     * @var string
     */
    private $data;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @param ApiHandler $apiHandler
     */
    public function __construct(ApiHandler $apiHandler)
    {
        $config = $apiHandler->getConfig();
        $this->url = $config->getUrl();
        $this->apiKey = $config->getApiKey();
    }

    /**
     * @param string $data
     * @throws InvalidParamException,JsonDecodingException
     */
    public function setData($data)
    {
        // check validity of json
        if (!is_array($data) || !is_object($data)) {
            json_decode($data);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new JsonDecodingException(json_last_error());
            }
            // no problems with JSON
            $this->data = $data;
        } else {
            throw new InvalidParamException('Data must be a valid JSON string');
        }
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return string $apiKey
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * description : sets the request data and method to null
     */
    public function clear()
    {
        $this->data = null;
        $this->method = null;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return
            [
                self::HEADER_ACCEPT_TYPE . self::HEADER_MIME_TYPE,
                self::HEADER_CONTENT_TYPE . self::HEADER_MIME_TYPE,
            ];
    }
}
