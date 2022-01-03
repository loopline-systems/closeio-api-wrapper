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

use LooplineSystems\CloseIoApiWrapper\Model\Phone;
use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    public function testInstantiateWithoutData(): void
    {
        $phone = new Phone();

        $this->assertNull($phone->getPhone());
        $this->assertNull($phone->getPhoneFormatted());
        $this->assertNull($phone->getType());
    }

    public function testInstantiateWithFullData(): void
    {
        $phone = new Phone([
            'phone' => '+393331234567',
            'phone_formatted' => '+39 333 12 34 567',
            'type' => 'mobile',
        ]);

        $this->assertSame('+393331234567', $phone->getPhone());
        $this->assertSame('+39 333 12 34 567', $phone->getPhoneFormatted());
        $this->assertSame('mobile', $phone->getType());
    }

    public function testInstantiateWithPartialData(): void
    {
        $phone = new Phone([
            'phone' => '+3902098765',
            'type' => 'mobile',
        ]);

        $this->assertSame('+3902098765', $phone->getPhone());
        $this->assertNull($phone->getPhoneFormatted());
        $this->assertSame('mobile', $phone->getType());
    }

    public function testInstantiateWithUnrequiredData(): void
    {
        $phone = new Phone([
            'extra' => 'demo',
        ]);

        $this->assertNull($phone->getPhone());
        $this->assertNull($phone->getPhoneFormatted());
        $this->assertNull($phone->getType());
    }

    /**
     * @dataProvider provideSerializedData
     */
    public function testSerializedOutput(array $data, $json): void
    {
        $phone = new Phone($data);

        $this->assertJsonStringEqualsJsonString($json, json_encode($phone));
    }

    public function provideSerializedData(): array
    {
        return [
            [
                [],
                '[]',
            ],
            [
                ['phone' => '+3902098765'],
                '{"phone":"+3902098765"}',
            ],
            [
                ['type' => 'office'],
                '{"type":"office"}',
            ],
            [
                ['phone' => '+3902098765', 'phone_formatted' => '+39 02 09 87 65', 'type' => 'office'],
                '{"phone":"+3902098765","phone_formatted":"+39 02 09 87 65","type":"office"}',
            ],
        ];
    }
}
