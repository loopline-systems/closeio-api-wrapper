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
     * @var string|null The body response
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
     * @param string|null    $body           The body response
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
     */
    public function getRequest(): CloseIoRequest
    {
        return $this->request;
    }

    /**
     * Gets the HTTP status code returned by this response.
     */
    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    /**
     * Gets the body content returned by this response.
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * Gets the decoded body response.
     */
    public function getDecodedBody(): array
    {
        return $this->decodedBody;
    }

    /**
     * Gets whether the Close.io server returned an error.
     */
    public function hasError(): bool
    {
        return isset($this->decodedBody['error']) || isset($this->decodedBody['errors']) || isset($this->decodedBody['field-errors']);
    }

    /**
     * Gets the HTTP headers returned by this response.
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
        if (empty($this->body) || $this->body === null) {
            $this->decodedBody = [];

            return;
        }

        $this->decodedBody = json_decode($this->body, true);

        if (json_last_error() !== \JSON_ERROR_NONE) {
            throw new JsonException('The body of the response could not be decoded as JSON.');
        }

        if (!\is_array($this->decodedBody)) {
            $this->decodedBody = [];
        }
    }
}
