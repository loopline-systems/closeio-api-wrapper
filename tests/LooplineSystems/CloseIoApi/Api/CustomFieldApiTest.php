<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper\Tests;

use LooplineSystems\CloseIoApiWrapper\Api\CustomFieldApi;
use LooplineSystems\CloseIoApiWrapper\CloseIoApiWrapper;
use LooplineSystems\CloseIoApiWrapper\CloseIoConfig;
use LooplineSystems\CloseIoApiWrapper\CloseIoResponse;
use LooplineSystems\CloseIoApiWrapper\Model\CustomField;

class CustomFieldApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider customFieldArrayProvider
     *
     * @param CustomField[] $customFieldArray
     */
    public function testGetCustomFields($customFieldArray)
    {
        $responseBody = [
            CloseIoResponse::GET_ALL_RESPONSE_HAS_MORE_KEY => false,
            CloseIoResponse::GET_ALL_RESPONSE_TOTAL_RESULTS_KEY => '3',
            CloseIoResponse::GET_RESPONSE_DATA_KEY => $customFieldArray
        ];

        $customFieldApi = $this->getCustomFieldApi();

        $expectedResponse = new CloseIoResponse();
        $expectedResponse->setReturnCode(200);
        $expectedResponse->setRawData(json_encode($responseBody));
        $expectedResponse->setData(json_decode($expectedResponse->getRawData(), true));

        // create stub
        $mockCurl = $this->getMockResponderCurl($expectedResponse);
        $customFieldApi->setCurl($mockCurl);

        $returnedcustomFields = $customFieldApi->getAllCustomFields();

        foreach ($returnedcustomFields as $key => $customField) {
            $this->assertTrue($customField == $customFieldArray[$key]);
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
        $customFieldApi = $this->getCustomFieldApi();

        $customField->setId('TestId');
        $originalCustomField = clone $customField;

        $returnedCustomField = $customField;
        $returnedCustomField->setName('Test Name');

        // init expected response
        $expectedResponse = new CloseIoResponse();
        $expectedResponse->setReturnCode('200');
        $expectedResponse->setRawData(json_encode($returnedCustomField));
        $expectedResponse->setData(json_decode($expectedResponse->getRawData(), true));

        // create stub
        $mockCurl = $this->getMockResponderCurl($expectedResponse);
        $customFieldApi->setCurl($mockCurl);

        /* @var CustomField $response */
        $response = $customFieldApi->updateCustomField($customField);

        $this->assertEquals($customField->getName(), $response->getName());
        $this->assertEquals($originalCustomField->getId(), $response->getId());
    }

    /**
     * @return CustomFieldApi
     */
    private function getCustomFieldApi()
    {
        // init wrapper
        $closeIoConfig = new CloseIoConfig();
        $closeIoConfig->setApiKey('testapikey');
        $closeIoApiWrapper = new CloseIoApiWrapper($closeIoConfig);

        return $closeIoApiWrapper->getCustomFieldApi();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     * @description Need to be careful of the order, if method() comes after expects() it will return null
     */
    private function getMockResponderCurl($expectedResponse)
    {
        // create stub
        $mockCurl = $this->getMockBuilder('Curl')
            ->setMethods(['getResponse'])
            ->getMock();

        // configure the stub.
        $mockCurl->method('getResponse')->willReturn($expectedResponse);

        $mockCurl->expects($this->once())
            ->method('getResponse');

        return $mockCurl;
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

