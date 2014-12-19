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
use LooplineSystems\CloseIoApiWrapper\CloseIoRequest;
use LooplineSystems\CloseIoApiWrapper\CloseIoResponse;
use LooplineSystems\CloseIoApiWrapper\Model\Lead;

class LeadsTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateLeadApi()
    {
        // init wrapper
        $closeIoConfig = new CloseIoConfig();
        $closeIoConfig->setApiKey('testapikey');
        $closeIoApiWrapper = new CloseIoApiWrapper($closeIoConfig);

        $leadApi = $closeIoApiWrapper->getLeadApi();
        $this->assertTrue(get_class($leadApi) === 'LooplineSystems\CloseIoApiWrapper\Api\LeadApi');
    }

    public function testUpdateLead()
    {
        // init wrapper
        $closeIoConfig = new CloseIoConfig();
        $closeIoConfig->setApiKey('testapikey');
        $closeIoApiWrapper = new CloseIoApiWrapper($closeIoConfig);

        $leadApi = $closeIoApiWrapper->getLeadApi();

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
        $mockCurl = $this->getMockBuilder('Curl')
            ->setMethods(array('getResponse'))
            ->getMock();

        // configure the stub.
        $mockCurl->method('getResponse')
            ->willReturn($expectedResponse);

        $mockCurl->expects($this->once())
            ->method('getResponse');

        $leadApi->setCurl($mockCurl);

        /* @var Lead $response */
        $response = $leadApi->updateLead($lead);

        $this->assertEquals($lead->getDescription(), $response->getDescription());
        $this->assertEquals($originalLead->getId(), $response->getId());
    }
}
