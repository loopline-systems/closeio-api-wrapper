<?php

declare(strict_types=1);

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
use LooplineSystems\CloseIoApiWrapper\Api\LeadApi;
use LooplineSystems\CloseIoApiWrapper\Client;
use LooplineSystems\CloseIoApiWrapper\CloseIoApiWrapper;
use LooplineSystems\CloseIoApiWrapper\Configuration;
use LooplineSystems\CloseIoApiWrapper\Model\Lead;
use Psr\Http\Message\RequestInterface;

class LeadsApiTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var HttpClientMock
     */
    protected $httpClient;

    /**
     * @var LeadApi
     */
    protected $leadApi;

    protected function setUp()
    {
        $this->httpClient = new HttpClientMock();

        $client = new Client(new Configuration('foo'), $this->httpClient);
        $closeIoApiWrapper = new CloseIoApiWrapper($client);

        $this->leadApi = $closeIoApiWrapper->getLeadApi();
    }

    /**
     * @param Lead $lead
     *
     * @description tests adding a lead using mock curl object
     * @dataProvider leadProvider
     */
    public function testAddLead(Lead $lead)
    {
        $this->httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(200, null, [], '{"id":"TestIdString"}'));

        $returnedLead = clone $lead;
        $returnedLead->setId('TestIdString');

        $createdLead = $this->leadApi->addLead($lead);

        $this->assertNotSame($returnedLead, $createdLead);
        $this->assertNull($lead->getId());
        $this->assertEquals('TestIdString', $createdLead->getId());
    }

    /**
     * @dataProvider leadProvider
     *
     * @param Lead $lead
     */
    public function testGetLead($lead)
    {
        $lead->setId('TestId');

        $this->httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(200, null, [], json_encode($lead)));

        $returnedLead = $this->leadApi->getLead('TestId');

        $this->assertEquals($returnedLead, $lead);
    }

    /**
     * @dataProvider leadArrayProvider
     *
     * @param Lead[] $leadsArray
     */
    public function testGetAllLeads($leadsArray)
    {
        $responseBody = [
            'has_more' => false,
            'data' => $leadsArray
        ];

        $this->httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(200, null, [], json_encode($responseBody)));

        $returnedLeads = $this->leadApi->getAllLeads();

        foreach ($returnedLeads as $key => $lead) {
            $this->assertEquals($leadsArray[$key], $lead);
        }
    }

    /**
     * @throws \LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException
     *
     * @param Lead $lead
     *
     * @dataProvider leadProvider
     */
    public function testUpdateLead($lead)
    {
        $lead->setId('TestId');
        $originalLead = clone $lead;

        $returnedLead = $lead;
        $returnedLead->setName('Test Name');

        $this->httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(200, null, [], json_encode($returnedLead)));

        $response = $this->leadApi->updateLead($lead);

        $this->assertNotSame($originalLead, $returnedLead);
        $this->assertEquals($lead->getDescription(), $response->getDescription());
        $this->assertEquals($originalLead->getId(), $response->getId());
    }

    public function testDeleteLead()
    {
        $this->httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(200, null, [], '{}'));

        $this->leadApi->deleteLead('foo');

        $lastRequest = $this->httpClient->getLastRequest();

        $this->assertInstanceOf(RequestInterface::class, $lastRequest);
        $this->assertEquals('https://app.close.io/api/v1/lead/foo/', (string) $lastRequest->getUri());
        $this->assertEquals('DELETE', $lastRequest->getMethod());
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

