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

use LooplineSystems\CloseIoApiWrapper\Exception\JsonException;

/**
 * This class represents a response received by a Close.io REST API.
 *
 * @author Stefano Arlandini <sarlandini@alice.it>
 */
class CloseIoResponse
{
    /**
     * @var CloseIoRequest The original request that returned this response
     */
    protected $request;

    /**
     * @var int The HTTP status code returned by this response
     */
    protected $httpStatusCode;

    /**
     * @var null|string The body response
     */
    protected $body;

    /**
     * @var array The decoded body response
     */
    protected $decodedBody;

    /**
     * @var array The HTTP headers returned by this response
     */
    protected $headers;

    /**
     * Constructor.
     *
     * @param CloseIoRequest $request        The original request that returned this response
     * @param int            $httpStatusCode The status code of this response
     * @param null|string    $body           The body response
     * @param array          $headers        The returned HTTP headers
     *
     * @throws JsonException If the response body failed to be decoded as JSON
     */
    public function __construct(CloseIoRequest $request, int $httpStatusCode, ?string $body = null, array $headers = [])
    {
        $this->request = $request;
        $this->httpStatusCode = $httpStatusCode;
        $this->body = $body;
        $this->headers = $headers;

        $this->decodeBody();
    }

    /**
     * Gets the original request that returned this response.
     *
     * @return CloseIoRequest
     */
    public function getRequest(): CloseIoRequest
    {
        return $this->request;
    }

    /**
     * Gets the HTTP status code returned by this response.
     *
     * @return int
     */
    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    /**
     * Gets the body content returned by this response.
     *
     * @return null|string
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * Gets the decoded body response.
     *
     * @return array
     */
    public function getDecodedBody(): array
    {
        return $this->decodedBody;
    }

    /**
     * Gets whether the Close.io server returned an error.
     *
     * @return bool
     */
    public function hasError(): bool
    {
        return isset($this->decodedBody['error']) || isset($this->decodedBody['errors']) || isset($this->decodedBody['field-errors']);
    }

    /**
     * Gets the HTTP headers returned by this response.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Converts the raw response into an array.
     *
     * @throws JsonException If the response body failed to be decoded as JSON
     */
    private function decodeBody(): void
    {
        $this->decodedBody = json_decode($this->body, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new JsonException('The body of the response could not be decoded as JSON.');
        }

        if (!is_array($this->decodedBody)) {
            $this->decodedBody = [];
        }
    }
}
