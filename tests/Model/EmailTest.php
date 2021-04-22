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

namespace Tests\LooplineSystems\CloseIoApiWrapper\Model;

use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;
use LooplineSystems\CloseIoApiWrapper\Model\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testInstantiateWithoutData(): void
    {
        $email = new Email();

        $this->assertNull($email->getEmail());
        $this->assertNull($email->getType());
    }

    public function testInstantiateWithFullData(): void
    {
        $email = new Email([
            'email' => 'user@test.com',
            'type' => 'home',
        ]);

        $this->assertSame('user@test.com', $email->getEmail());
        $this->assertSame('home', $email->getType());
    }

    public function testInstantiateWithPartialData(): void
    {
        $email = new Email([
            'email' => 'user@test.com',
        ]);

        $this->assertSame('user@test.com', $email->getEmail());
        $this->assertNull($email->getType());
    }

    public function testInstantiateWithUnrequiredData(): void
    {
        $email = new Email([
            'extra' => 'demo',
        ]);

        $this->assertNull($email->getEmail());
        $this->assertNull($email->getType());
    }

    public function testThrowExceptionForWrongEmailAddress(): void
    {
        $this->expectException(InvalidParamException::class);

        $email = new Email([
            'email' => 'wrongATemail',
        ]);
    }

    /**
     * @dataProvider provideSerializedData
     */
    public function testSerializedOutput(array $data, $json): void
    {
        $email = new Email($data);

        $this->assertJsonStringEqualsJsonString($json, json_encode($email));
    }

    public function provideSerializedData(): array
    {
        return [
            [
                [],
                '[]',
            ],
            [
                ['email' => 'user@test.com'],
                '{"email":"user@test.com"}',
            ],
            [
                ['type' => 'home'],
                '{"type":"home"}',
            ],
            [
                ['email' => 'user@test.com', 'type' => 'home'],
                '{"email":"user@test.com","type":"home"}',
            ],
        ];
    }
}
