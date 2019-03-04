<?php

/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems.
 *
 * @see      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 *
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

declare(strict_types=1);

namespace LooplineSystems\CloseIoApiWrapper;

use Fig\Http\Message\RequestMethodInterface;
use LooplineSystems\CloseIoApiWrapper\Exception\InvalidHttpMethodException;

/**
 * This class represents a request to send to a REST API endpoint of Close.io.
 *
 * @author Stefano Arlandini <sarlandini@alice.it>
 */
class CloseIoRequest
{
    /**
     * @var string The HTTP method for this request
     */
    protected $method;

    /**
     * @var string The REST endpoint for this request
     */
    protected $endpoint;

    /**
     * @var array The parameters to send in the query string
     */
    protected $queryParams = [];

    /**
     * @var array The parameters to send in the body
     */
    protected $bodyParams = [];

    /**
     * Constructor.
     *
     * @param string $method      The HTTP method
     * @param string $endpoint    The REST endpoint
     * @param array  $queryParams The parameters to send in the query string
     * @param array  $bodyParams  The parameters to send in the body
     *
     * @throws InvalidHttpMethodException
     */
    public function __construct(string $method, string $endpoint, array $queryParams = [], array $bodyParams = [])
    {
        if (!\in_array($method, [RequestMethodInterface::METHOD_GET, RequestMethodInterface::METHOD_POST, RequestMethodInterface::METHOD_PUT, RequestMethodInterface::METHOD_DELETE], true)) {
            throw new InvalidHttpMethodException();
        }

        $this->method = $method;
        $this->endpoint = $endpoint;
        $this->queryParams = $queryParams;
        $this->bodyParams = $bodyParams;
    }

    /**
     * Gets the HTTP method for this request.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Gets the REST endpoint for this request.
     *
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * Gets the parameters to send in the query string.
     *
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * Sets the parameters to send in the query string of this request.
     *
     * @param array $queryParams The parameters
     */
    public function setQueryParams(array $queryParams): void
    {
        $this->queryParams = $queryParams;
    }

    /**
     * Gets the parameters to send as body of this request (only POST and PUT
     * HTTP methods can contain a body).
     *
     * @return array
     */
    public function getBodyParams(): array
    {
        return $this->bodyParams;
    }

    /**
     * Sets the parameters to send as body of this request.
     *
     * @param array $bodyParams The parameters
     */
    public function setBodyParams(array $bodyParams): void
    {
        $this->bodyParams = $bodyParams;
    }

    /**
     * Gets the URL for this request.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->appendParamsToUrl($this->endpoint, $this->queryParams);
    }

    /**
     * Appends the given set of params to the URL.
     *
     * @param string $url    The URL the params will be appended to
     * @param array  $params The params to append to the URL
     *
     * @return string
     */
    protected function appendParamsToUrl(string $url, array $params): string
    {
        if (empty($params['_fields'])) {
            unset($params['_fields']);
        }

        if (empty($params)) {
            return $url;
        }

        // If the _fields param is set transform it to a single string so that
        // it's not urlencoded as an array
        if (isset($params['_fields']) && \is_array($params['_fields'])) {
            $params['_fields'] = array_unique(array_merge($params['_fields'], ['id']));
            $params['_fields'] = implode(',', $params['_fields']);
        }

        // If there is no question mark in the URL we can just add the params
        // to the query string and exit early
        if (strpos($url, '?') === false) {
            return $url . '?' . http_build_query($params, '', '&');
        }

        list($path, $query) = explode('?', $url, 2);

        parse_str($query, $existingParams);

        $params = array_merge($params, $existingParams);

        return $path . '?' . http_build_query($params, '', '&');
    }
}
