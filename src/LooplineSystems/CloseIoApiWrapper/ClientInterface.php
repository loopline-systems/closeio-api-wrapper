<?php

declare(strict_types=1);

/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper;

use Http\Client\HttpClient;
use LooplineSystems\CloseIoApiWrapper\Exception\CloseIoResponseException;
use LooplineSystems\CloseIoApiWrapper\Exception\JsonException;

/**
 * This interface defines a contract that must be implemented by all classes
 * willing to serve as clients of the Close.io REST APIs.
 *
 * @author Stefano Arlandini <sarlandini@alice.it>
 */
interface ClientInterface
{
    /**
     * Gets the client configuration.
     *
     * @return Configuration
     */
    public function getConfiguration(): Configuration;

    /**
     * Gets the HTTP client, configured to authenticate with the server.
     *
     * @return HttpClient
     */
    public function getHttpClient(): HttpClient;

    /**
     * Sends a GET request to Close.io REST API and returns the result.
     *
     * @param string $endpoint The REST endpoint for the request
     * @param array  $params   The parameters to send with the request
     *
     * @return CloseIoResponse
     */
    public function get(string $endpoint, array $params = []): CloseIoResponse;

    /**
     * Sends a POST request to Close.io REST API and returns the result.
     *
     * @param string $endpoint The REST endpoint for the request
     * @param array  $params   The parameters to send with the request
     *
     * @return CloseIoResponse
     */
    public function post(string $endpoint, array $params = []): CloseIoResponse;

    /**
     * Sends a PUT request to Close.io REST API and returns the result.
     *
     * @param string $endpoint The REST endpoint for the request
     * @param array  $params   The parameters to send with the request
     *
     * @return CloseIoResponse
     */
    public function put(string $endpoint, array $params = []): CloseIoResponse;

    /**
     * Sends a DELETE request to Close.io REST API and returns the result.
     *
     * @param string $endpoint The REST endpoint for the request
     * @param array  $params   The parameters to send with the request
     *
     * @return CloseIoResponse
     */
    public function delete(string $endpoint, array $params = []): CloseIoResponse;

    /**
     * Sends a request to the server and returns the response.
     *
     * @param CloseIoRequest $request The request
     *
     * @return CloseIoResponse
     *
     * @throws JsonException            If the response body could not be parsed as JSON
     * @throws CloseIoResponseException If the response errored
     */
    public function sendRequest(CloseIoRequest $request): CloseIoResponse;
}
