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

use LooplineSystems\CloseIoApiWrapper\Model\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    public function testInstantiateWithoutData(): void
    {
        $url = new Url();

        $this->assertNull($url->getType());
        $this->assertNull($url->getUrl());
    }

    public function testInstantiateWithFullData(): void
    {
        $url = new Url([
            'url' => 'https://www.test.com',
            'type' => 'website',
        ]);

        $this->assertSame('website', $url->getType());
        $this->assertSame('https://www.test.com', $url->getUrl());
    }

    public function testInstantiateWithPartialData(): void
    {
        $url = new Url([
            'url' => 'https://www.test.com',
        ]);

        $this->assertNull($url->getType());
        $this->assertSame('https://www.test.com', $url->getUrl());
    }

    public function testInstantiateWithUnrequiredData(): void
    {
        $url = new Url([
            'extra' => 'demo',
        ]);

        $this->assertNull($url->getType());
        $this->assertNull($url->getUrl());
    }

    /**
     * @dataProvider provideSerializedData
     */
    public function testSerializedOutput(array $data, $json): void
    {
        $url = new Url($data);

        $this->assertJsonStringEqualsJsonString($json, json_encode($url));
    }

    public function provideSerializedData(): array
    {
        return [
            [
                [],
                '[]',
            ],
            [
                ['url' => 'https://www.test.com'],
                '{"url":"https://www.test.com"}',
            ],
            [
                ['type' => 'website'],
                '{"type":"website"}',
            ],
            [
                ['url' => 'https://www.test.com', 'type' => 'website'],
                '{"url":"https://www.test.com","type":"website"}',
            ],
        ];
    }
}
