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
use Http\Message\RequestFactory as RequestFactoryInterface;
use Http\Message\UriFactory as UriFactoryInterface;
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
     * The version of the library.
     */
    const VERSION = '0.8.x-dev';

    /**
     * The user agent used by this client when making HTTP requests.
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
     * @var UriFactoryInterface The URI factory
     */
    private $uriFactory;

    /**
     * @var RequestFactoryInterface The factory of PSR-7 requests
     */
    private $requestFactory;

    /**
     * Constructor.
     *
     * @param Configuration                $configuration  The configuration of the client
     * @param HttpClientInterface|null     $httpClient     The HTTP client
     * @param UriFactoryInterface|null     $uriFactory     The URI factory
     * @param RequestFactoryInterface|null $requestFactory The factory of PSR-7 requests
     */
    public function __construct(Configuration $configuration, ?HttpClientInterface $httpClient = null, ?UriFactoryInterface $uriFactory = null, ?RequestFactoryInterface $requestFactory = null)
    {
        $this->configuration = $configuration;
        $this->uriFactory = $uriFactory ?: UriFactoryDiscovery::find();
        $this->requestFactory = $requestFactory ?: MessageFactoryDiscovery::find();
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
    public function get(string $endpoint, array $queryParams = []): CloseIoResponse
    {
        return $this->sendRequest(new CloseIoRequest(RequestMethodInterface::METHOD_GET, $endpoint, $queryParams));
    }

    /**
     * {@inheritdoc}
     */
    public function post(string $endpoint, array $queryParams = [], array $bodyParams = []): CloseIoResponse
    {
        return $this->sendRequest(new CloseIoRequest(RequestMethodInterface::METHOD_POST, $endpoint, $queryParams, $bodyParams));
    }

    /**
     * {@inheritdoc}
     */
    public function put(string $endpoint, array $queryParams = [], array $bodyParams = []): CloseIoResponse
    {
        return $this->sendRequest(new CloseIoRequest(RequestMethodInterface::METHOD_PUT, $endpoint, $queryParams, $bodyParams));
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $endpoint, array $queryParams = []): CloseIoResponse
    {
        return $this->sendRequest(new CloseIoRequest(RequestMethodInterface::METHOD_DELETE, $endpoint, $queryParams));
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest(CloseIoRequest $request): CloseIoResponse
    {
        $requestBody = null;

        if (!empty($request->getBodyParams()) && \in_array($request->getMethod(), [RequestMethodInterface::METHOD_POST, RequestMethodInterface::METHOD_PUT], true)) {
            $params = $request->getBodyParams();

            foreach ($params as $name => $value) {
                if ($value instanceof \DateTimeInterface) {
                    $params[$name] = $value->format(\DATE_ATOM);
                }
            }

            $requestBody = json_encode($params);
        }

        $rawRequest = $this->requestFactory->createRequest($request->getMethod(), $request->getUrl(), [], $requestBody);

        try {
            $rawResponse = $this->httpClient->sendRequest($rawRequest);
        } catch (HttpClientException $exception) {
            throw new CloseIoException($exception->getMessage(), $exception->getCode(), $exception);
        }

        $response = new CloseIoResponse($request, $rawResponse->getStatusCode(), (string) $rawResponse->getBody(), $rawResponse->getHeaders());

        if ($response->getHttpStatusCode() !== StatusCodeInterface::STATUS_OK || $response->hasError()) {
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
