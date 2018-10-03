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

use Fig\Http\Message\RequestMethodInterface;
use Fig\Http\Message\StatusCodeInterface;
use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\Plugin\HeaderSetPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\Exception as HttpClientException;
use Http\Client\HttpClient as HttpClientInterface;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\Authentication\BasicAuth;
use Http\Message\MessageFactory;
use Http\Message\UriFactory;
use LooplineSystems\CloseIoApiWrapper\Exception\CloseIoException;
use LooplineSystems\CloseIoApiWrapper\Exception\CloseIoResponseException;

/**
 * Basic implementation of a client to interact with the Close.io REST APIs.
 *
 * @author Stefano Arlandini <sarlandini@alice.it>
 */
final class Client implements ClientInterface
{
    /**
     * The version of the library
     */
    const VERSION = '0.8.x-dev';

    /**
     * The user agent used by this client when making HTTP requests
     */
    const USER_AGENT = 'CloseIoApiWrapper/' . self::VERSION;

    /**
     * @var Configuration The storage of configuration options
     */
    private $configuration;

    /**
     * @var HttpClientInterface The HTTP client
     */
    private $httpClient;

    /**
     * @var UriFactory The URI factory
     */
    private $uriFactory;

    /**
     * @var MessageFactory The factory of PSR-7 requests
     */
    private $messageFactory;

    /**
     * Constructor.
     *
     * @param Configuration            $configuration  The configuration of the client
     * @param HttpClientInterface|null $httpClient     The HTTP client
     * @param UriFactory|null          $uriFactory     The URI factory
     * @param MessageFactory|null      $messageFactory The factory of PSR-7 requests
     */
    public function __construct(Configuration $configuration, ?HttpClientInterface $httpClient = null, ?UriFactory $uriFactory = null, ?MessageFactory $messageFactory = null)
    {
        $this->configuration = $configuration;
        $this->uriFactory = $uriFactory ?: UriFactoryDiscovery::find();
        $this->messageFactory = $messageFactory ?: MessageFactoryDiscovery::find();
        $this->httpClient = $this->createHttpClientInstance($httpClient ?: HttpClientDiscovery::find());
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function getHttpClient(): HttpClientInterface
    {
        return $this->httpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $endpoint, array $params = []): CloseIoResponse
    {
        return $this->sendRequest(new CloseIoRequest(RequestMethodInterface::METHOD_GET, $endpoint, $params));
    }

    /**
     * {@inheritdoc}
     */
    public function post(string $endpoint, array $params = []): CloseIoResponse
    {
        return $this->sendRequest(new CloseIoRequest(RequestMethodInterface::METHOD_POST, $endpoint, $params));
    }

    /**
     * {@inheritdoc}
     */
    public function put(string $endpoint, array $params = []): CloseIoResponse
    {
        return $this->sendRequest(new CloseIoRequest(RequestMethodInterface::METHOD_PUT, $endpoint, $params));
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $endpoint, array $params = []): CloseIoResponse
    {
        return $this->sendRequest(new CloseIoRequest(RequestMethodInterface::METHOD_DELETE, $endpoint, $params));
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest(CloseIoRequest $request): CloseIoResponse
    {
        $requestBody = null;

        if (!empty($request->getBodyParams())) {
            $requestBody = json_encode($request->getBodyParams());
        }

        $rawRequest = $this->messageFactory->createRequest($request->getMethod(), $request->getUrl(), [], $requestBody);

        try {
            $rawResponse = $this->httpClient->sendRequest($rawRequest);
        } catch (HttpClientException $exception) {
            throw new CloseIoException($exception->getMessage(), $exception->getCode(), $exception);
        }

        $response = new CloseIoResponse($request, $rawResponse->getStatusCode(), (string) $rawResponse->getBody(), $rawResponse->getHeaders());

        if (StatusCodeInterface::STATUS_OK !== $response->getHttpStatusCode() || $response->hasError()) {
            throw CloseIoResponseException::create($response);
        }

        return $response;
    }

    /**
     * Returns a new HTTP client that wraps the given one and configures it to
     * use the base URL specified in the configuration and the access token for
     * the Basic Auth.
     *
     * @param HttpClientInterface $httpClient The HTTP client to decorate
     *
     * @return HttpClientInterface
     */
    private function createHttpClientInstance(HttpClientInterface $httpClient): HttpClientInterface
    {
        return new PluginClient($httpClient, [
            new BaseUriPlugin($this->uriFactory->createUri($this->configuration->getBaseUrl())),
            new AuthenticationPlugin(new BasicAuth($this->configuration->getApiKey(), '')),
            new HeaderSetPlugin([
                'User-Agent' => self::USER_AGENT,
                'Content-Type' => 'application/json',
            ]),
        ]);
    }
}
