<?php declare(strict_types=1);
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace Tests\LooplineSystems\CloseIoApiWrapper\Library\Exception;

use LooplineSystems\CloseIoApiWrapper\Library\Exception\JsonDecodingException;

class ExceptionsTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @param string $data
     *
     * @throws JsonDecodingException
     * @dataProvider badJsonProvider
     */
    public function testJsonDecodeException($data, $expectedMessage)
    {
        $this->expectException(JsonDecodingException::class);
        json_decode($data);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $exception = new JsonDecodingException(json_last_error());
            $this->assertTrue($exception->getMessage() === $expectedMessage);
            throw $exception;
        }
    }

    /**
     * @param mixed $data
     *
     * @throws JsonDecodingException
     * @dataProvider badDataProvider
     */
    public function testJsonEncodeException($data, $expectedMessage)
    {
        $this->expectException(JsonDecodingException::class);
        json_encode($data);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $exception = new JsonDecodingException(json_last_error());
            $this->assertTrue($exception->getMessage() === $expectedMessage);
            throw $exception;
        }
    }

    public function badJsonProvider()
    {
        return [
            [
                "{'Organization': 'PHP Documentation Team'}",
                JsonDecodingException::JSON_ERROR_SYNTAX_MESSAGE
            ],
            [
                '{ bar: "baz" }',
                JsonDecodingException::JSON_ERROR_SYNTAX_MESSAGE
            ],
            [
                "{ 'bar': 'baz' }",
                JsonDecodingException::JSON_ERROR_SYNTAX_MESSAGE
            ],
            [
                '{ bar: "baz", }',
                JsonDecodingException::JSON_ERROR_SYNTAX_MESSAGE
            ]
        ];
    }

    public function badDataProvider()
    {
        return [
            [
                "\xB1\x31",
                JsonDecodingException::JSON_ERROR_UTF8_MESSAGE
            ],
        ];
    }
}
