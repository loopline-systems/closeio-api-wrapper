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

use LooplineSystems\CloseIoApiWrapper\CloseIoRequest;
use LooplineSystems\CloseIoApiWrapper\Exception\InvalidHttpMethodException;
use PHPUnit\Framework\TestCase;

class CloseIoRequestTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $request = new CloseIoRequest('GET', '/foo/', ['foo' => 'bar']);

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/foo/', $request->getEndpoint());
        $this->assertEquals(['foo' => 'bar'], $request->getParams());
    }

    /**
     * @dataProvider getUrlHandlesParametersCorrectlyDataProvider
     */
    public function testGetUrlHandlesParametersCorrectly(string $initialUrl, string $expectedUrl, array $params): void
    {
        $request = new CloseIoRequest('GET', $initialUrl, $params);

        $this->assertEquals($expectedUrl, $request->getUrl());
    }

    public function getUrlHandlesParametersCorrectlyDataProvider(): array
    {
        return [
            ['/foo/', '/foo/', []],
            ['/foo/?foo=bar', '/foo/?bar=foo&foo=bar', ['bar' => 'foo']],
            ['/foo/?', '/foo/?', []],
            ['/foo/?', '/foo/?foo=bar', ['foo' => 'bar']],
            ['/foo/', '/foo/', ['_fields' => []]],
            ['/foo/', '/foo/?_fields=foo%2Cbar%2Cid', ['_fields' => ['foo', 'bar']]],
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
