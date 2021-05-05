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

namespace Tests\LooplineSystems\CloseIoApiWrapper\Api;

use Http\Discovery\MessageFactoryDiscovery;
use Http\Mock\Client as HttpClientMock;
use LooplineSystems\CloseIoApiWrapper\Api\CustomFieldApi;
use LooplineSystems\CloseIoApiWrapper\Client;
use LooplineSystems\CloseIoApiWrapper\CloseIoApiWrapper;
use LooplineSystems\CloseIoApiWrapper\Configuration;
use LooplineSystems\CloseIoApiWrapper\Model\CustomField;
use PHPUnit\Framework\TestCase;

class CustomFieldApiTest extends TestCase
{
    /**
     * @var HttpClientMock
     */
    protected $httpClient;

    /**
     * @var CustomFieldApi
     */
    protected $customFieldApi;

    protected function setUp(): void
    {
        $this->httpClient = new HttpClientMock();

        $client = new Client(new Configuration('foo'), $this->httpClient);
        $closeIoApiWrapper = new CloseIoApiWrapper($client);

        $this->customFieldApi = $closeIoApiWrapper->getCustomFieldApi();
    }

    /**
     * @dataProvider customFieldArrayProvider
     *
     * @param CustomField[] $customFieldArray
     *
     * @group legacy
     */
    public function testGetCustomFields($customFieldArray): void
    {
        $responseBody = [
            'has_more' => false,
            'data' => $customFieldArray,
        ];

        $this->httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(200, null, [], json_encode($responseBody)));

        $returnedcustomFields = $this->customFieldApi->getAllCustomFields();

        foreach ($returnedcustomFields as $key => $customField) {
            $this->assertEquals($customFieldArray[$key], $customField);
        }
    }

    /**
     * @dataProvider customFieldDataProvider
     *
     * @param CustomField $customField
     *
     * @group legacy
     */
    public function testUpdateCustomField($customField): void
    {
        $customField->setId('TestId');
        $originalCustomField = clone $customField;

        $returnedCustomField = $customField;
        $returnedCustomField->setName('Test Name');

        $this->httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(200, null, [], json_encode($returnedCustomField)));

        $response = $this->customFieldApi->updateCustomField($customField);

        $this->assertNotSame($originalCustomField, $response);
        $this->assertEquals($customField->getName(), $response->getName());
        $this->assertEquals($originalCustomField->getId(), $response->getId());
    }

    public function customFieldDataProvider(): array
    {
        return [
            [
                new CustomField(['name' => 'Test Name']),
            ],
        ];
    }

    public function customFieldArrayProvider(): array
    {
        $customField = new CustomField(['name' => 'Test Name']);

        $customFieldOne = clone $customField;
        $customFieldTwo = clone $customField;
        $customFieldThree = clone $customField;

        $customFieldOne->setId('TestIdOne');
        $customFieldTwo->setId('TestIdTwo');
        $customFieldThree->setId('TestIdThree');

        $customFields = [
            $customFieldOne,
            $customFieldTwo,
            $customFieldThree,
        ];

        return [[$customFields]];
    }
}
