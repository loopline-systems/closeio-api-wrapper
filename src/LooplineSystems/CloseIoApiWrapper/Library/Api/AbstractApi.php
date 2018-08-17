<?php declare(strict_types=1);
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper\Library\Api;

use LooplineSystems\CloseIoApiWrapper\CloseIoRequest;
use LooplineSystems\CloseIoApiWrapper\CloseIoResponse;
use LooplineSystems\CloseIoApiWrapper\Library\Curl\Curl;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\BadApiRequestException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\UrlNotSetException;

abstract class AbstractApi implements ApiInterface
{
    const NAME = null;

    /**
     * @var array
     */
    protected $urls;

    /**
     * @var Curl
     */
    protected $curl;

    /**
     * @var CloseIoRequest
     */
    protected $apiRequest;

    /**
     * @var ApiHandler
     */
    private $apiHandler;

    /**
     * @param ApiHandler $apiHandler
     */
    public function __construct(ApiHandler $apiHandler)
    {
        $this->curl = new Curl();
        $this->initUrls();
        $this->apiRequest = new CloseIoRequest($apiHandler);
        $this->apiHandler = $apiHandler;
    }

    /**
     * @param Curl $curl
     */
    public function setCurl($curl)
    {
        $this->curl = $curl;
    }

    /**
     * @return string
     */
    public function getName()
    {
        if (static::NAME !== null) {
            return static::NAME;
        }

        throw new \RuntimeException("Please  implement a CONST NAME = '<Name>' in your concrete Api!");
    }

    /**
     * @param CloseIoRequest $request
     *
     * @return CloseIoResponse
     *
     * @throws UrlNotSetException
     * @throws BadApiRequestException
     * @throws ResourceNotFoundException
     */
    protected function triggerPut(CloseIoRequest $request)
    {
        $finalRequest = $this->finalizeRequest($request, Curl::METHOD_PUT);
        return $this->curl->getResponse($finalRequest);
    }

    /**
     * @param CloseIoRequest $request
     *
     * @return CloseIoResponse
     *
     * @throws UrlNotSetException
     * @throws BadApiRequestException
     * @throws ResourceNotFoundException
     */
    protected function triggerDelete(CloseIoRequest $request)
    {
        $finalRequest = $this->finalizeRequest($request, Curl::METHOD_DELETE);
        return $this->curl->getResponse($finalRequest);
    }

    /**
     * @param CloseIoRequest $request
     *
     * @return CloseIoResponse
     *
     * @throws UrlNotSetException
     * @throws BadApiRequestException
     * @throws ResourceNotFoundException
     */
    protected function triggerPatch(CloseIoRequest $request)
    {
        $finalRequest = $this->finalizeRequest($request, Curl::METHOD_PATCH);
        return $this->curl->getResponse($finalRequest);
    }

    /**
     * @param CloseIoRequest $request
     *
     * @return CloseIoResponse
     *
     * @throws UrlNotSetException
     * @throws BadApiRequestException
     * @throws ResourceNotFoundException
     */
    protected function triggerGet(CloseIoRequest $request)
    {
        $finalRequest = $this->finalizeRequest($request, Curl::METHOD_GET);
        return $this->curl->getResponse($finalRequest);
    }

    /**
     * @param CloseIoRequest $request
     *
     * @return CloseIoResponse
     *
     * @throws UrlNotSetException
     * @throws BadApiRequestException
     * @throws ResourceNotFoundException
     */
    protected function triggerPost(CloseIoRequest $request)
    {
        $finalRequest = $this->finalizeRequest($request, Curl::METHOD_POST);
        return $this->curl->getResponse($finalRequest);
    }

    /**
     * @param CloseIoRequest $request
     * @param string $method
     *
     * @return CloseIoRequest
     */
    private function finalizeRequest(CloseIoRequest $request, $method)
    {
        $request->setMethod($method);
        return $request;
    }

    /**
     * @param string $parameter
     * @param string $replacement
     * @param string $url
     * @return string
     */
    private function prepareUrlSingle($parameter, $replacement, $url)
    {
        return str_replace('[:' . $parameter . ']', $replacement, $url);
    }

    /**
     * @param string $urlKey
     * @param array $replacements
     * @return mixed|string
     */
    private function prepareUrlForKey($urlKey, array $replacements = [])
    {
        $url = $this->getUrlForKey($urlKey);
        foreach ($replacements as $parameter => $value) {
            $url = $this->prepareUrlSingle($parameter, $value, $url);
        }
        return $url;
    }

    /**
     * @param string $urlKey
     * @param string $data
     * @param array $urlReplacements
     * @param array $queryParams
     * @return CloseIoRequest
     * @throws InvalidParamException
     */
    protected function prepareRequest($urlKey, $data = null, array $urlReplacements = [], array $queryParams = [])
    {
        $this->apiRequest->clear();
        $this->apiRequest->setData($data);
        $this->apiRequest->setUrl($this->apiHandler->getConfig()->getUrl());

        $url = $this->prepareUrlForKey($urlKey, $urlReplacements);

        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }

        $this->apiRequest->setUrl($this->getUrlPrefix() . $url);
        return $this->apiRequest;
    }

    /**
     * @param string $key
     * @return string $url
     */
    protected function getUrlForKey($key)
    {
        return isset($this->urls[$key]) ? $this->urls[$key] : null;
    }

    /**
     * @return string
     */
    protected function getUrlPrefix()
    {
        return $this->apiRequest->getUrl();
    }

    /**
     * @return ApiHandler
     */
    public function getApiHandler()
    {
        return $this->apiHandler;
    }

    /**
     * @return string
     */
    protected function getApiKey()
    {
        return $this->apiRequest->getApiKey();
    }

    /**
     * @description initialize the routes array
     */
    abstract protected function initUrls();
}
