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

namespace LooplineSystems\CloseIoApiWrapper\Library\Api;

use LooplineSystems\CloseIoApiWrapper\ClientInterface;

abstract class AbstractApi
{
    /**
     * @var array
     */
    protected $urls;

    /**
     * @var ClientInterface
     */
    protected $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;

        $this->initUrls();
    }

    /**
     * @param string $parameter
     * @param string $replacement
     * @param string $url
     *
     * @return string
     */
    private function prepareUrlSingle($parameter, $replacement, $url)
    {
        return str_replace('[:' . $parameter . ']', $replacement, $url);
    }

    /**
     * @param string $urlKey
     *
     * @return mixed|string
     */
    protected function prepareUrlForKey($urlKey, array $replacements = [])
    {
        $url = $this->getUrlForKey($urlKey);
        foreach ($replacements as $parameter => $value) {
            $url = $this->prepareUrlSingle($parameter, $value, $url);
        }

        return $url;
    }

    /**
     * @param string $key
     *
     * @return string $url
     */
    protected function getUrlForKey($key)
    {
        return isset($this->urls[$key]) ? $this->urls[$key] : null;
    }

    /**
     * @description initialize the routes array
     */
    abstract protected function initUrls();
}
