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
use LooplineSystems\CloseIoApiWrapper\CloseIoRequest;
use LooplineSystems\CloseIoApiWrapper\Exception\InvalidHttpMethodException;
use PHPUnit\Framework\TestCase;

class CloseIoRequestTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $request = new CloseIoRequest(RequestMethodInterface::METHOD_GET, '/foo/', ['foo' => 'bar'], ['bar' => 'foo']);

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/foo/', $request->getEndpoint());
        $this->assertEquals(['foo' => 'bar'], $request->getQueryParams());
        $this->assertEquals(['bar' => 'foo'], $request->getBodyParams());

        $request->setQueryParams(['bar' => 'foo']);
        $request->setBodyParams(['foo' => 'bar']);

        $this->assertEquals(['bar' => 'foo'], $request->getQueryParams());
        $this->assertEquals(['foo' => 'bar'], $request->getBodyParams());
    }

    /**
     * @dataProvider getUrlHandlesParametersCorrectlyDataProvider
     */
    public function testGetUrlHandlesParametersCorrectly(string $requestMethod, string $initialUrl, string $expectedUrl, array $queryParams, array $bodyParams): void
    {
        $request = new CloseIoRequest($requestMethod, $initialUrl, $queryParams, $bodyParams);

        $this->assertEquals($expectedUrl, $request->getUrl());
    }

    public function getUrlHandlesParametersCorrectlyDataProvider(): array
    {
        return [
            [
                RequestMethodInterface::METHOD_GET,
                '/foo/',
                '/foo/',
                [],
                [],
            ],
            [
                RequestMethodInterface::METHOD_GET,
                '/foo/?foo=bar',
                '/foo/?bar=foo&foo=bar',
                [
                    'bar' => 'foo',
                ],
                [],
            ],
            [
                RequestMethodInterface::METHOD_GET,
                '/foo/?',
                '/foo/?',
                [],
                [],
            ],
            [
                RequestMethodInterface::METHOD_GET,
                '/foo/?',
                '/foo/?foo=bar',
                [
                    'foo' => 'bar',
                ],
                [],
            ],
            [
                RequestMethodInterface::METHOD_GET,
                '/foo/',
                '/foo/',
                [
                    '_fields' => [],
                ],
                [],
            ],
            [
                RequestMethodInterface::METHOD_GET,
                '/foo/',
                '/foo/?_fields=foo%2Cbar%2Cid',
                [
                    '_fields' => ['foo', 'bar'],
                ],
                [],
            ],
            [
                RequestMethodInterface::METHOD_POST,
                '/foo/',
                '/foo/?_fields=foo%2Cbar%2Cid',
                [
                    '_fields' => ['foo', 'bar'],
                ],
                [
                    'foo' => 'bar',
                ],
            ],
            [
                RequestMethodInterface::METHOD_PUT,
                '/foo/',
                '/foo/?_fields=foo%2Cbar%2Cid',
                [
                    '_fields' => ['foo', 'bar'],
                ],
                [
                    'foo' => 'bar',
                ],
            ],
        ];
    }

    /**
     * @dataProvider requestMethodIsValidatedAndNormalizedDataProvider
     */
    public function testRequestMethodIsValidatedAndNormalized(string $method, string $normalizedMethod, bool $isValid): void
    {
        if (!$isValid) {
            $this->expectException(InvalidHttpMethodException::class);
        }

        $request = new CloseIoRequest($method, '/foo/', ['foo' => 'bar']);

        $this->assertEquals($normalizedMethod, $request->getMethod());
    }

    public function requestMethodIsValidatedAndNormalizedDataProvider(): array
    {
        return [
            ['GET', 'GET', true],
            ['POST', 'POST', true],
            ['PUT', 'PUT', true],
            ['DELETE', 'DELETE', true],
            ['get', 'GET', false],
            ['post', 'POST', false],
            ['put', 'PUT', false],
            ['delete', 'DELETE', false],
            ['foo', 'foo', false],
        ];
    }
}
