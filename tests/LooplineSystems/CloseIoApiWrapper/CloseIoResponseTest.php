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

use Fig\Http\Message\RequestMethodInterface;
use Fig\Http\Message\StatusCodeInterface;
use LooplineSystems\CloseIoApiWrapper\CloseIoRequest;
use LooplineSystems\CloseIoApiWrapper\CloseIoResponse;

class CloseIoResponseTest extends \PHPUnit\Framework\TestCase
{
    public function testGetters(): void
    {
        $request = new CloseIoRequest('GET', '/foo/');
        $response = new CloseIoResponse($request, 200, '{"foo":"bar"}', ['bar' => 'foo']);

        $this->assertSame($request, $response->getRequest());
        $this->assertEquals(200, $response->getHttpStatusCode());
        $this->assertEquals('{"foo":"bar"}', $response->getBody());
        $this->assertEquals(['foo' => 'bar'], $response->getDecodedBody());
        $this->assertEquals(['bar' => 'foo'], $response->getHeaders());
    }

    /**
     * @dataProvider getDecodedBodyDataProvider
     */
    public function testGetDecodedBody(string $body, array $expectedDecodedBody): void
    {
        $response = new CloseIoResponse(new CloseIoRequest('GET', '/foo/'), 200, $body);

        $this->assertEquals($expectedDecodedBody, $response->getDecodedBody());
    }

    public function getDecodedBodyDataProvider(): array
    {
        return [
            ['{"foo":"bar"}', ['foo' => 'bar']],
            ['false', []],
        ];
    }

    /**
     * @expectedException \LooplineSystems\CloseIoApiWrapper\Exception\JsonException
     */
    public function testResponseThrowsExceptionIfDecodedBodyContainsInvalidJson(): void
    {
        new CloseIoResponse(new CloseIoRequest('GET', '/foo/'), 200, 'foo');
    }

    /**
     * @dataProvider hasErrorDataProvider
     */
    public function testHasError(string $responseBody, bool $isError): void
    {
        $response = new CloseIoResponse(new CloseIoRequest(RequestMethodInterface::METHOD_GET, '/foo'), StatusCodeInterface::STATUS_OK, $responseBody);

        $this->assertSame($isError, $response->hasError());
    }

    public function hasErrorDataProvider(): array
    {
        return [
            ['{"error":"foo"}', true],
            ['{"errors":["foo"]}', true],
            ['{"field-errors":["foo"]}', true],
            ['{}', false]
        ];
    }
}
