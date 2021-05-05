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

use LooplineSystems\CloseIoApiWrapper\Library\UrlUtils;

/**
 * This class stores the configuration of the Close.io client.
 *
 * @author Stefano Arlandini <sarlandini@alice.it>
 */
final class Configuration
{
    /**
     * @var string the URL of the server where the REST APIs are located
     */
    private $baseUrl;

    /**
     * @var string the API key used to authenticate with the server
     */
    private $apiKey;

    /**
     * Class constructor.
     *
     * @param string $apiKey  The API key used to authenticate with the server
     * @param string $baseUrl The URL of the server where the REST APIs are located
     *
     * @throws \InvalidArgumentException If any of the parameters is invalid
     */
    public function __construct(string $apiKey, string $baseUrl = 'https://api.close.com/api/v1')
    {
        if (empty($apiKey)) {
            throw new \InvalidArgumentException('The API key must not be an empty string.');
        }

        if (!UrlUtils::validate($baseUrl)) {
            throw new \InvalidArgumentException('The $baseUrl argument must be an absolute URL.');
        }

        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    /**
     * Gets the URL of the server where the REST APIs are located.
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Gets the API key used to authenticate with the server.
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }
}
