<?php

declare(strict_types=1);

/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace Tests\LooplineSystems\CloseIoApiWrapper;

use Http\Discovery\MessageFactoryDiscovery;
use Http\Mock\Client as HttpClientMock;
use LooplineSystems\CloseIoApiWrapper\Client;
use LooplineSystems\CloseIoApiWrapper\CloseIoRequest;
use LooplineSystems\CloseIoApiWrapper\Configuration;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class ClientTest extends TestCase
{
    public function testGetConfiguration(): void
    {
        $configuration = new Configuration('foo');
        $client = new Client($configuration);

        $this->assertSame($configuration, $client->getConfiguration());
    }

    public function testGet(): void
    {
        $httpClient = new HttpClientMock();
        $httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(200, null, [], '{}'));

        $client = new Client(new Configuration('foo'), $httpClient);
        $client->get('/foo/', ['foo' => 'bar', 'bar' => 'foo']);

        $lastRequest = $httpClient->getLastRequest();

        $this->assertInstanceOf(RequestInterface::class, $lastRequest);
        $this->assertEquals('https://app.close.io/api/v1/foo/?foo=bar&bar=foo', (string) $lastRequest->getUri());
        $this->assertEquals('GET', $lastRequest->getMethod());
    }

    public function testPost(): void
    {
        $httpClient = new HttpClientMock();
        $httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(200, null, [], '{}'));

        $client = new Client(new Configuration('foo'), $httpClient);
        $client->post('/foo/', ['foo' => 'bar', 'bar' => 'foo']);

        $lastRequest = $httpClient->getLastRequest();

        $this->assertInstanceOf(RequestInterface::class, $lastRequest);
        $this->assertEquals('https://app.close.io/api/v1/foo/?foo=bar&bar=foo', (string) $lastRequest->getUri());
        $this->assertEquals('POST', $lastRequest->getMethod());
    }

    public function testPut(): void
    {
        $httpClient = new HttpClientMock();
        $httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(200, null, [], '{}'));

        $client = new Client(new Configuration('foo'), $httpClient);
        $client->put('/foo/', ['foo' => 'bar', 'bar' => 'foo']);

        $lastRequest = $httpClient->getLastRequest();

        $this->assertInstanceOf(RequestInterface::class, $lastRequest);
        $this->assertEquals('https://app.close.io/api/v1/foo/?foo=bar&bar=foo', (string) $lastRequest->getUri());
        $this->assertEquals('PUT', $lastRequest->getMethod());
    }

    public function testDelete(): void
    {
        $httpClient = new HttpClientMock();
        $httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(200, null, [], '{}'));

        $client = new Client(new Configuration('foo'), $httpClient);
        $client->delete('/foo/', []);

        $lastRequest = $httpClient->getLastRequest();

        $this->assertInstanceOf(RequestInterface::class, $lastRequest);
        $this->assertEquals('https://app.close.io/api/v1/foo/', (string) $lastRequest->getUri());
        $this->assertEquals('DELETE', $lastRequest->getMethod());
    }

    public function testSendRequest(): void
    {
        $httpClient = new HttpClientMock();
        $httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(200, null, [], '{"foo":"bar"}'));

        $client = new Client(new Configuration('foo'), $httpClient);
        $response = $client->sendRequest(new CloseIoRequest('GET', '/foo/', ['foo' => 'bar', 'bar' => 'foo']));

        $lastRequest = $httpClient->getLastRequest();

        $this->assertInstanceOf(RequestInterface::class, $lastRequest);
        $this->assertEquals('https://app.close.io/api/v1/foo/?foo=bar&bar=foo', (string) $lastRequest->getUri());
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals('{"foo":"bar"}', (string) $response->getBody());
        $this->assertEquals(['foo' => 'bar'], $response->getDecodedBody());
    }
}
