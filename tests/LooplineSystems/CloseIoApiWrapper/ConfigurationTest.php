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

use LooplineSystems\CloseIoApiWrapper\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

class ConfigurationTest extends TestCase
{
    /**
     * @dataProvider optionsDataProvider
     */
    public function testGetters(string $option, string $value, string $getterMethod): void
    {
        $options = array_merge(['api_key' => 'foo'], [$option => $value]);

        $configuration = new Configuration($options);

        $this->assertEquals($value, $configuration->$getterMethod());
    }

    public function optionsDataProvider(): array
    {
        return [
            ['base_url', 'http://www.example.com/', 'getBaseUrl'],
            ['api_key', 'foo', 'getApiKey'],
        ];
    }

    /**
     * @dataProvider serverOptionIsValidatedCorrectly
     */
    public function testServerOptionIsValidatedCorrectly(string $value, bool $isValid)
    {
        if ($isValid) {
            $this->expectNotToPerformAssertions();
        } else {
            $this->expectException(InvalidOptionsException::class);
            $this->expectExceptionMessageRegExp('/^The option ".*" with value ".*" is invalid\.$/');
        }

        new Configuration(['base_url' => $value, 'api_key' => 'foo']);
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
