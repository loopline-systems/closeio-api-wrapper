<?php

declare(strict_types=1);

/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper\Exception;

use Fig\Http\Message\StatusCodeInterface;
use LooplineSystems\CloseIoApiWrapper\CloseIoResponse;
use Throwable;

/**
 * This exception is thrown when a Close.io response returns an error.
 *
 * @author Stefano Arlandini <sarlandini@alice.it>
 */
class CloseIoResponseException extends CloseIoException
{
    private const UNKNOWN_ERROR_MESSAGE = 'Unknown error from Close.io REST API.';

    /**
     * @var CloseIoResponse The response that threw the exception
     */
    private $response;

    /**
     * Constructor.
     *
     * @param CloseIoResponse $response The response that threw the exception
     * @param Throwable|null  $previous The previous throwable used for the exception chaining
     */
    public function __construct(CloseIoResponse $response, Throwable $previous = null)
    {
        $this->response = $response;

        parent::__construct($response->getDecodedBody()['error'] ?? self::UNKNOWN_ERROR_MESSAGE, 0, $previous);
    }

    /**
     * A factory method for creating the appropriate exception based on the
     * response from Close.io.
     *
     * @param CloseIoResponse $response The response that threw the exception
     *
     * @return self
     */
    public static function create(CloseIoResponse $response): self
    {
        $data = $response->getDecodedBody();
        $message = $data['error'] ?? self::UNKNOWN_ERROR_MESSAGE;

        switch ($response->getHttpStatusCode()) {
            case StatusCodeInterface::STATUS_UNAUTHORIZED:
                return new static($response, new CloseIoAuthenticationException($message, 0));
            case StatusCodeInterface::STATUS_TOO_MANY_REQUESTS:
                return new static($response, new CloseIoThrottleException($message, 0));
            default:
                return new static($response);
        }
    }

    /**
     * Gets the response that threw the exception.
     *
     * @return CloseIoResponse
     */
    public function getResponse(): CloseIoResponse
    {
        return $this->response;
    }
}
