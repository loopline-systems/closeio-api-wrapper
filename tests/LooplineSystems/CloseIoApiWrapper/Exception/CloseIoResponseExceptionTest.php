<?php

declare(strict_types=1);

namespace Tests\LooplineSystems\CloseIoApiWrapper\Exception;

use Fig\Http\Message\RequestMethodInterface;
use Fig\Http\Message\StatusCodeInterface;
use LooplineSystems\CloseIoApiWrapper\CloseIoRequest;
use LooplineSystems\CloseIoApiWrapper\CloseIoResponse;
use LooplineSystems\CloseIoApiWrapper\Exception\CloseIoAuthenticationException;
use LooplineSystems\CloseIoApiWrapper\Exception\CloseIoBadRequestException;
use LooplineSystems\CloseIoApiWrapper\Exception\CloseIoResourceNotFoundException;
use LooplineSystems\CloseIoApiWrapper\Exception\CloseIoResponseException;
use LooplineSystems\CloseIoApiWrapper\Exception\CloseIoThrottleException;
use PHPUnit\Framework\TestCase;

class CloseIoResponseExceptionTest extends TestCase
{
    /**
     * @dataProvider constructorDataProvider
     */
    public function testConstructor(string $responseBody, string $expectedErrorMessage): void
    {
        $response = new CloseIoResponse(new CloseIoRequest(RequestMethodInterface::METHOD_GET, 'http://www.example.com'), StatusCodeInterface::STATUS_OK, $responseBody);
        $previousException = new \Exception();
        $exception = new CloseIoResponseException($response, $previousException);

        $this->assertSame($response, $exception->getResponse());
        $this->assertSame($previousException, $exception->getPrevious());
        $this->assertEquals($expectedErrorMessage, $exception->getMessage());
    }

    public function constructorDataProvider(): array
    {
        return [
            [
                '{}',
                'Unknown error from Close.io REST API.',
            ],
            [
                '{"error":"foo"}',
                'foo',
            ],
        ];
    }

    /**
     * @dataProvider createDataProvider
     */
    public function testCreate(int $httpStatusCode, string $responseBody, string $expectedExceptionClass, string $expectedErrorMessage): void
    {
        $request = new CloseIoRequest(RequestMethodInterface::METHOD_GET, 'http://www.example.com');
        $response = new CloseIoResponse($request, $httpStatusCode, $responseBody);
        $exception = CloseIoResponseException::create($response);

        $this->assertInstanceOf($expectedExceptionClass, $exception);
        $this->assertEquals($expectedErrorMessage, $exception->getMessage());
    }

    public function createDataProvider(): array
    {
        return [
            [
                StatusCodeInterface::STATUS_UNAUTHORIZED,
                '{"error":"foo"}',
                CloseIoAuthenticationException::class,
                'foo',
            ],
            [
                StatusCodeInterface::STATUS_TOO_MANY_REQUESTS,
                '{"error":"foo"}',
                CloseIoThrottleException::class,
                'foo',
            ],
            [
                StatusCodeInterface::STATUS_NOT_FOUND,
                '{"error":"foo"}',
                CloseIoResourceNotFoundException::class,
                'foo',
            ],
            [
                StatusCodeInterface::STATUS_BAD_REQUEST,
                '{"error":"foo"}',
                CloseIoBadRequestException::class,
                'foo',
            ],
            [
                StatusCodeInterface::STATUS_SERVICE_UNAVAILABLE,
                '{}',
                CloseIoResponseException::class,
                'Unknown error from Close.io REST API.',
            ],
        ];
    }
}
