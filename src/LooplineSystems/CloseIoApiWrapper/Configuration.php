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

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * This class stores the configuration of the Close.io client.
 *
 * @author Stefano Arlandini <sarlandini@alice.it>
 */
final class Configuration
{
    /**
     * @var array The configuration options
     */
    private $options = [];

    /**
     * Class constructor.
     *
     * @param array $options The configuration options
     */
    public function __construct(array $options = [])
    {
        $optionsResolver = new OptionsResolver();

        $this->configureOptions($optionsResolver);

        $this->options = $optionsResolver->resolve($options);
    }

    /**
     * Gets the URL of the server where the REST APIs are located.
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->options['base_url'];
    }

    /**
     * Gets the API key used to authenticate with the server.
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->options['api_key'];
    }

    /**
     * Configures the options of the client.
     *
     * @param OptionsResolver $resolver The resolver for the options
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     */
    private function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('base_url', 'https://app.close.io/api/v1/');

        $resolver->setRequired('api_key');

        $resolver->setAllowedTypes('base_url', 'string');
        $resolver->setAllowedTypes('api_key', 'string');

        $resolver->setAllowedValues('base_url', function ($value) {
            return filter_var($value, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED | FILTER_FLAG_HOST_REQUIRED);
        });
    }
}
