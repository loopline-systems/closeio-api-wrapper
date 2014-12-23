<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper\Tests;

use LooplineSystems\CloseIoApiWrapper\CloseIoApiWrapper;
use LooplineSystems\CloseIoApiWrapper\CloseIoConfig;
use LooplineSystems\CloseIoApiWrapper\CloseIoResponse;
use LooplineSystems\CloseIoApiWrapper\Model\Lead;

class LeadsApiTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateLeadApi()
    {
        $leadApi = $this->getLeadsApi();
        $this->assertTrue(get_class($leadApi) === 'LooplineSystems\CloseIoApiWrapper\Api\LeadApi');
    }

    /**
     * @throws \LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException
     * @throws \LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException
     */
    public function testUpdateLead()
    {
        $leadApi = $this->getLeadsApi();

        // init lead
        $lead = new Lead();
        $lead->setId('TestIdString');
        $lead->setDescription('Updated Description');
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
        $leadApi->setCurl($mockCurl);

        /* @var Lead $response */
        $response = $leadApi->updateLead($lead);

        $this->assertEquals($lead->getDescription(), $response->getDescription());
        $this->assertEquals($originalLead->getId(), $response->getId());
    }

    /**
     * @throws \LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException
     */
    public function testDeleteLead()
    {
        $leadApi = $this->getLeadsApi();

        $id = 'lead-to-be-deleted';

        // init expected response
        $expectedResponse = new CloseIoResponse();
        $expectedResponse->setReturnCode('200');
        $expectedResponse->setCurlInfoRaw(['url' => $leadApi->getApiHandler()->getConfig()->getUrl() . $id]);

        // create stub
        $mockCurl = $this->getMockResponderCurl($expectedResponse);
        $leadApi->setCurl($mockCurl);

        $response = $leadApi->deleteLead($id);
        $this->assertTrue($response === $expectedResponse);
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
     */
    private function getMockResponderCurl($expectedResponse)
    {
        // create stub
        $mockCurl = $this->getMockBuilder('Curl')
            ->setMethods(array('getResponse'))
            ->getMock();

        $mockCurl->expects($this->once())
            ->method('getResponse');

        // configure the stub.
        $mockCurl->method('getResponse')->willReturn($expectedResponse);

        return $mockCurl;
    }
}

