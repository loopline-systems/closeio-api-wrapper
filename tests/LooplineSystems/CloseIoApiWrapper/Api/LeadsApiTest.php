<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace Tests\LooplineSystems\CloseIoApiWrapper\Api;

use LooplineSystems\CloseIoApiWrapper\CloseIoApiWrapper;
use LooplineSystems\CloseIoApiWrapper\CloseIoConfig;
use LooplineSystems\CloseIoApiWrapper\CloseIoResponse;
use LooplineSystems\CloseIoApiWrapper\Model\Lead;

class LeadsApiTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @param Lead $lead
     *
     * @description tests adding a lead using mock curl object
     * @dataProvider leadProvider
     */
    public function testAddLead(Lead $lead)
    {
        $leadsApi = $this->getLeadsApi();

        $returnedLead = clone $lead;
        $returnedLead->setId('TestIdString');

        $expectedResponse = new CloseIoResponse();
        $expectedResponse->setReturnCode(201);
        $expectedResponse->setRawData(json_encode($returnedLead));
        $expectedResponse->setData(json_decode($expectedResponse->getRawData(), true));

        $leadsApi->setCurl($this->getMockResponderCurl($expectedResponse));

        $responseLead = $leadsApi->addLead($lead);

        $createdLead = $responseLead;

        $this->assertTrue($createdLead->getName() === $lead->getName());
        $this->assertNotEmpty($createdLead->getId());
        $this->assertEmpty($lead->getId());
    }

    /**
     * @dataProvider leadProvider
     *
     * @param Lead $lead
     */
    public function testGetLead($lead)
    {
        $leadsApi = $this->getLeadsApi();

        $id = 'TestId';
        $lead->setId($id);

        $expectedResponse = new CloseIoResponse();
        $expectedResponse->setReturnCode(200);
        $expectedResponse->setRawData(json_encode($lead));
        $expectedResponse->setData(json_decode($expectedResponse->getRawData(), true));

        // create stub
        $mockCurl = $this->getMockResponderCurl($expectedResponse);
        $leadsApi->setCurl($mockCurl);

        $returnedLead = $leadsApi->getLead($id);

        $this->assertTrue($returnedLead == $lead);
    }

    /**
     * @dataProvider leadArrayProvider
     *
     * @param Lead[] $leadsArray
     */
    public function testGetAllLeads($leadsArray)
    {
        $responseBody = [
            CloseIoResponse::GET_ALL_RESPONSE_HAS_MORE_KEY => false,
            CloseIoResponse::GET_ALL_RESPONSE_TOTAL_RESULTS_KEY => '3',
            CloseIoResponse::GET_RESPONSE_DATA_KEY => $leadsArray
        ];

        $leadsApi = $this->getLeadsApi();

        $expectedResponse = new CloseIoResponse();
        $expectedResponse->setReturnCode(200);
        $expectedResponse->setRawData(json_encode($responseBody));
        $expectedResponse->setData(json_decode($expectedResponse->getRawData(), true));

        // create stub
        $mockCurl = $this->getMockResponderCurl($expectedResponse);
        $leadsApi->setCurl($mockCurl);

        $returnedLeads = $leadsApi->getAllLeads();

        foreach ($returnedLeads as $key => $lead) {
            $this->assertTrue($lead == $leadsArray[$key]);
        }
    }

    /**
     * @throws \LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException
     * @throws \LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException
     *
     * @param Lead $lead
     *
     * @dataProvider leadProvider
     */
    public function testUpdateLead($lead)
    {
        $leadsApi = $this->getLeadsApi();

        $lead->setId('TestId');
        $originalLead = clone $lead;

        $returnedLead = $lead;
        $returnedLead->setName('Test Name');

        // init expected response
        $expectedResponse = new CloseIoResponse();
        $expectedResponse->setReturnCode('200');
        $expectedResponse->setRawData(json_encode($returnedLead));
        $expectedResponse->setData(json_decode($expectedResponse->getRawData(), true));

        // create stub
        $mockCurl = $this->getMockResponderCurl($expectedResponse);
        $leadsApi->setCurl($mockCurl);

        /* @var Lead $response */
        $response = $leadsApi->updateLead($lead);

        $this->assertEquals($lead->getDescription(), $response->getDescription());
        $this->assertEquals($originalLead->getId(), $response->getId());
    }

    /**
     * @throws \LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException
     */
    public function testDeleteLead()
    {
        $leadsApi = $this->getLeadsApi();

        $id = 'lead-to-be-deleted';

        // init expected response
        $expectedResponse = new CloseIoResponse();
        $expectedResponse->setReturnCode('200');
        $expectedResponse->setCurlInfoRaw(['url' => $leadsApi->getApiHandler()->getConfig()->getUrl() . $id]);

        // create stub
        $mockCurl = $this->getMockResponderCurl($expectedResponse);
        $leadsApi->setCurl($mockCurl);

        $leadsApi->deleteLead($id);
    }

    /**
     * @return \LooplineSystems\CloseIoApiWrapper\Api\LeadApi
     */
    private function getLeadsApi()
    {
        // init wrapper
        $closeIoConfig = new CloseIoConfig();
        $closeIoConfig->setApiKey('testapikey');
        $closeIoApiWrapper = new CloseIoApiWrapper($closeIoConfig);

        return $closeIoApiWrapper->getLeadApi();
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
    public function leadProvider()
    {
        return [
            [
                (new Lead(['name' => 'Test Name', 'description' => 'Test Description']))
            ]
        ];
    }

    /**
     * @return array
     */
    public function leadArrayProvider()
    {
        $lead = new Lead(['name' => 'Test Name', 'description' => 'Test Description']);

        // set up leads to be returned
        $leadOne = clone $lead;
        $leadTwo = clone $lead;
        $leadThree = clone $lead;

        $leadOne->setId('TestIdOne');
        $leadTwo->setId('TestIdTwo');
        $leadThree->setId('TestIdThree');

        $leadsArray = [
            $leadOne,
            $leadTwo,
            $leadThree
        ];

        return [
            [
                $leadsArray
            ],
        ];
    }
}

