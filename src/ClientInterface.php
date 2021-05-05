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

use Http\Client\HttpClient as HttpClientInterface;
use LooplineSystems\CloseIoApiWrapper\Exception\CloseIoException;
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
     */
    public function getConfiguration(): Configuration;

    /**
     * Gets the HTTP client, configured to authenticate with the server.
     */
    public function getHttpClient(): HttpClientInterface;

    /**
     * Sends a GET request to Close.io REST API and returns the result.
     *
     * @param string $endpoint    The REST endpoint for the request
     * @param array  $queryParams The parameters to send in the query string
     *
     * @throws CloseIoException         If an error happens while processing the request
     * @throws CloseIoResponseException If the response errored
     * @throws JsonException            If the response body could not be parsed as JSON
     */
    public function get(string $endpoint, array $queryParams = []): CloseIoResponse;

    /**
     * Sends a POST request to Close.io REST API and returns the result.
     *
     * @param string $endpoint    The REST endpoint for the request
     * @param array  $queryParams The parameters to send in the query string
     * @param array  $bodyParams  The parameters to send as body of the request
     *
     * @throws CloseIoException         If an error happens while processing the request
     * @throws CloseIoResponseException If the response errored
     * @throws JsonException            If the response body could not be parsed as JSON
     */
    public function post(string $endpoint, array $queryParams = [], array $bodyParams = []): CloseIoResponse;

    /**
     * Sends a PUT request to Close.io REST API and returns the result.
     *
     * @param string $endpoint    The REST endpoint for the request
     * @param array  $queryParams The parameters to send in the query string
     * @param array  $bodyParams  The parameters to send as body of the request
     *
     * @throws CloseIoException         If an error happens while processing the request
     * @throws CloseIoResponseException If the response errored
     * @throws JsonException            If the response body could not be parsed as JSON
     */
    public function put(string $endpoint, array $queryParams = [], array $bodyParams = []): CloseIoResponse;

    /**
     * Sends a DELETE request to Close.io REST API and returns the result.
     *
     * @param string $endpoint    The REST endpoint for the request
     * @param array  $queryParams The parameters to send in the query string
     *
     * @throws CloseIoException         If an error happens while processing the request
     * @throws CloseIoResponseException If the response errored
     * @throws JsonException            If the response body could not be parsed as JSON
     */
    public function delete(string $endpoint, array $queryParams = []): CloseIoResponse;

    /**
     * Sends a request to the server and returns the response.
     *
     * @param CloseIoRequest $request The request
     *
     * @throws CloseIoException         If an error happens while processing the request
     * @throws CloseIoResponseException If the response errored
     * @throws JsonException            If the response body could not be parsed as JSON
     */
    public function sendRequest(CloseIoRequest $request): CloseIoResponse;
}
