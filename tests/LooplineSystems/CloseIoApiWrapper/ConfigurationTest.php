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

use LooplineSystems\CloseIoApiWrapper\Configuration;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    public function testGetters(): void
    {
        $configuration = new Configuration('foo', 'http://www.example.com/');

        $this->assertEquals('http://www.example.com/', $configuration->getBaseUrl());
        $this->assertEquals('foo', $configuration->getApiKey());
    }

    /**
     * @dataProvider serverOptionIsValidatedCorrectly
     */
    public function testServerOptionIsValidatedCorrectly(string $baseUrl, bool $isValid)
    {
        if ($isValid) {
            $this->expectNotToPerformAssertions();
        } else {
            $this->expectException(\InvalidArgumentException::class);
            $this->expectExceptionMessage('The $baseUrl argument must be an absolute URL.');
        }

        new Configuration('foo', $baseUrl);
    }

    public function serverOptionIsValidatedCorrectly(): array
    {
        return [
            ['', false],
            ['foo', false],
            ['https://', false],
            ['://www.example.com', false],
            ['https://www.example.com', true],
            ['https://www.example.com/api/v1', true],
        ];
    }
}
