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

namespace Tests\LooplineSystems\CloseIoApiWrapper;

use Fig\Http\Message\RequestMethodInterface;
use Fig\Http\Message\StatusCodeInterface;
use Http\Client\Exception\TransferException;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Mock\Client as HttpClientMock;
use LooplineSystems\CloseIoApiWrapper\Client;
use LooplineSystems\CloseIoApiWrapper\CloseIoRequest;
use LooplineSystems\CloseIoApiWrapper\Configuration;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class ClientTest extends TestCase
{
    /**
     * @var HttpClientMock
     */
    private $httpClient;

    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        $this->httpClient = new HttpClientMock();
        $this->client = new Client(new Configuration('foo'), $this->httpClient);
    }

    public function testGetConfiguration(): void
    {
        $this->assertAttributeSame($this->client->getConfiguration(), 'configuration', $this->client);
    }

    public function testGet(): void
    {
        $this->httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(StatusCodeInterface::STATUS_OK, null, [], '{}'));

        $this->client->get('/foo/', ['foo' => 'bar', 'bar' => 'foo']);

        $lastRequest = $this->httpClient->getLastRequest();

        $this->assertInstanceOf(RequestInterface::class, $lastRequest);
        $this->assertEquals('https://app.close.io/api/v1/foo/?foo=bar&bar=foo', (string) $lastRequest->getUri());
        $this->assertEquals('GET', $lastRequest->getMethod());
    }

    public function testPost(): void
    {
        $this->httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(StatusCodeInterface::STATUS_OK, null, [], '{}'));

        $this->client->post('/foo/', ['foo' => 'bar'], ['bar' => 'foo']);

        $lastRequest = $this->httpClient->getLastRequest();

        $this->assertInstanceOf(RequestInterface::class, $lastRequest);
        $this->assertEquals('https://app.close.io/api/v1/foo/?foo=bar', (string) $lastRequest->getUri());
        $this->assertEquals('POST', $lastRequest->getMethod());
        $this->assertEquals('{"bar":"foo"}', (string) $lastRequest->getBody());
    }

    public function testPut(): void
    {
        $this->httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(StatusCodeInterface::STATUS_OK, null, [], '{}'));

        $this->client->put('/foo/', ['foo' => 'bar'], ['bar' => 'foo']);

        $lastRequest = $this->httpClient->getLastRequest();

        $this->assertInstanceOf(RequestInterface::class, $lastRequest);
        $this->assertEquals('https://app.close.io/api/v1/foo/?foo=bar', (string) $lastRequest->getUri());
        $this->assertEquals('PUT', $lastRequest->getMethod());
        $this->assertEquals('{"bar":"foo"}', (string) $lastRequest->getBody());
    }

    public function testDelete(): void
    {
        $this->httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(StatusCodeInterface::STATUS_OK, null, [], '{}'));

        $this->client->delete('/foo/', []);

        $lastRequest = $this->httpClient->getLastRequest();

        $this->assertInstanceOf(RequestInterface::class, $lastRequest);
        $this->assertEquals('https://app.close.io/api/v1/foo/', (string) $lastRequest->getUri());
        $this->assertEquals('DELETE', $lastRequest->getMethod());
    }

    /**
     * @dataProvider sendRequestDataProvider
     */
    public function testSendRequest(string $requestMethod, array $queryParams, array $bodyParams, string $expectedRequestUrl, string $expectedRequestBody): void
    {
        $this->httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(StatusCodeInterface::STATUS_OK, null, [], '{"foo":"bar"}'));

        $response = $this->client->sendRequest(new CloseIoRequest($requestMethod, '/foo/', $queryParams, $bodyParams));

        $lastRequest = $this->httpClient->getLastRequest();

        $this->assertInstanceOf(RequestInterface::class, $lastRequest);
        $this->assertEquals($expectedRequestUrl, (string) $lastRequest->getUri());
        $this->assertEquals($expectedRequestBody, (string) $lastRequest->getBody());
        $this->assertEquals($requestMethod, $lastRequest->getMethod());
        $this->assertEquals('{"foo":"bar"}', (string) $response->getBody());
        $this->assertEquals(['foo' => 'bar'], $response->getDecodedBody());
    }

    public function sendRequestDataProvider(): array
    {
        return [
            [
                RequestMethodInterface::METHOD_GET,
                ['foo' => 'bar'],
                ['bar' => 'foo'],
                'https://app.close.io/api/v1/foo/?foo=bar',
                '',
            ],
            [
                RequestMethodInterface::METHOD_POST,
                ['foo' => 'bar'],
                ['bar' => 'foo'],
                'https://app.close.io/api/v1/foo/?foo=bar',
                '{"bar":"foo"}',
            ],
            [
                RequestMethodInterface::METHOD_PUT,
                ['foo' => 'bar'],
                ['bar' => 'foo'],
                'https://app.close.io/api/v1/foo/?foo=bar',
                '{"bar":"foo"}',
            ],
            [
                RequestMethodInterface::METHOD_DELETE,
                ['foo' => 'bar'],
                ['bar' => 'foo'],
                'https://app.close.io/api/v1/foo/?foo=bar',
                '',
            ],
        ];
    }

    /**
     * @expectedException \LooplineSystems\CloseIoApiWrapper\Exception\CloseIoException
     */
    public function testSendRequestThrowsOnBadRequest(): void
    {
        $this->httpClient->addException(new TransferException());

        $this->client->sendRequest(new CloseIoRequest(RequestMethodInterface::METHOD_GET, '/foo/'));
    }

    /**
     * @expectedException \LooplineSystems\CloseIoApiWrapper\Exception\CloseIoException
     */
    public function testSendRequestThrowsOnResponseThatHasErrors(): void
    {
        $this->httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(StatusCodeInterface::STATUS_OK, null, [], '{"error":"foo"}'));

        $this->client->sendRequest(new CloseIoRequest(RequestMethodInterface::METHOD_GET, '/foo/'));
    }

    /**
     * @expectedException \LooplineSystems\CloseIoApiWrapper\Exception\CloseIoException
     */
    public function testSendRequestThrowsOnResponseWithStatusCodeDifferentFromOk()
    {
        $this->httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(StatusCodeInterface::STATUS_NOT_FOUND, null, [], '{}'));

        $this->client->sendRequest(new CloseIoRequest(RequestMethodInterface::METHOD_GET, '/foo/'));
    }
}
