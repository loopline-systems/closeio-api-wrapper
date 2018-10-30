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
     * @var array The parameters to send with this request
     */
    protected $params = [];

    /**
     * Constructor.
     *
     * @param string $method   The HTTP method
     * @param string $endpoint The REST endpoint
     * @param array  $params   The parameters to send
     *
     * @throws InvalidHttpMethodException
     */
    public function __construct(string $method, string $endpoint, array $params = [])
    {
        if (!\in_array($method, [RequestMethodInterface::METHOD_GET, RequestMethodInterface::METHOD_POST, RequestMethodInterface::METHOD_PUT, RequestMethodInterface::METHOD_DELETE], true)) {
            throw new InvalidHttpMethodException();
        }

        $this->method = $method;
        $this->endpoint = $endpoint;
        $this->params = $params;
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
     * Gets the parameters to send with this request.
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Sets the parameters to send with this request.
     *
     * @param array $params The parameters
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    /**
     * Gets the parameters to send as body of this request (only POST and PUT
     * HTTP methods can contain a body).
     *
     * @return array
     */
    public function getBodyParams(): array
    {
        if (\in_array($this->method, [RequestMethodInterface::METHOD_POST, RequestMethodInterface::METHOD_PUT], true)) {
            return $this->params;
        }

        return [];
    }

    /**
     * Gets the URL for this request.
     *
     * @return string
     */
    public function getUrl(): string
    {
        $url = $this->endpoint;

        if (\in_array($this->method, [RequestMethodInterface::METHOD_GET, RequestMethodInterface::METHOD_POST, RequestMethodInterface::METHOD_PUT], true)) {
            $url = $this->appendParamsToUrl($url, $this->params);
        }

        return $url;
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
        if (false === strpos($url, '?')) {
            return $url . '?' . http_build_query($params, '', '&');
        }

        list($path, $query) = explode('?', $url, 2);

        parse_str($query, $existingParams);

        $params = array_merge($params, $existingParams);

        return $path . '?' . http_build_query($params, '', '&');
    }
}
