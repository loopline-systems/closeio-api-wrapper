<?php declare(strict_types=1);
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace Tests\LooplineSystems\CloseIoApiWrapper\Api;

use Http\Discovery\MessageFactoryDiscovery;
use Http\Mock\Client as HttpClientMock;
use LooplineSystems\CloseIoApiWrapper\Api\CustomFieldApi;
use LooplineSystems\CloseIoApiWrapper\Client;
use LooplineSystems\CloseIoApiWrapper\CloseIoApiWrapper;
use LooplineSystems\CloseIoApiWrapper\Configuration;
use LooplineSystems\CloseIoApiWrapper\Model\CustomField;

class CustomFieldApiTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var HttpClientMock
     */
    protected $httpClient;

    /**
     * @var CustomFieldApi
     */
    protected $customFieldApi;

    protected function setUp()
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
     */
    public function testGetCustomFields($customFieldArray)
    {
        $responseBody = [
            'has_more' => false,
            'data' => $customFieldArray
        ];

        $this->httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(200, null, [], json_encode($responseBody)));

        $returnedcustomFields = $this->customFieldApi->getAllCustomFields();

        foreach ($returnedcustomFields as $key => $customField) {
            $this->assertEquals($customFieldArray[$key], $customField);
        }
    }

    /**
     * @test
     * @dataProvider customFieldDataProvider
     *
     * @param CustomField $customField
     */
    public function testUpdateCustomField($customField)
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

    /**
     * @return array
     */
    public function customFieldDataProvider()
    {
        return [
            [
                new CustomField(['name' => 'Test Name'])
            ]
        ];
    }

    /**
     * @return array
     */
    public function customFieldArrayProvider()
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
            $customFieldThree
        ];

        return [[$customFields]];
    }
}

