<?php declare(strict_types=1);
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace Tests\LooplineSystems\CloseIoApiWrapper\Api;

use LooplineSystems\CloseIoApiWrapper\Api\ActivityApi;
use LooplineSystems\CloseIoApiWrapper\CloseIoApiWrapper;
use LooplineSystems\CloseIoApiWrapper\CloseIoConfig;
use LooplineSystems\CloseIoApiWrapper\CloseIoResponse;
use LooplineSystems\CloseIoApiWrapper\Library\Curl\Curl;
use LooplineSystems\CloseIoApiWrapper\Model\SmsActivity;

class ActivityApiTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var CloseIoApiWrapper
     */
    private $closeIoApiWrapper;

    protected function setUp()
    {
        $closeIoConfig = new CloseIoConfig();
        $closeIoConfig->setApiKey('testapikey');

        $this->closeIoApiWrapper = new CloseIoApiWrapper($closeIoConfig);
    }

    /**
     * @description tests updating a sms activity using mock curl object
     */
    public function testUpdateSms()
    {
        $sms = new SmsActivity();
        $sms->setId('test-124');
        $sms->setLocalPhone('+123456789');

        $activitiesApi = $this->closeIoApiWrapper->getActivitiesApi();
        $smsActivitiesApi = $this->closeIoApiWrapper->getSmsActivitiesApi();

        $returnedSms = clone $sms;

        $expectedResponse = new CloseIoResponse();
        $expectedResponse->setReturnCode(201);
        $expectedResponse->setRawData(json_encode($returnedSms));
        $expectedResponse->setData(json_decode($expectedResponse->getRawData(), true));

        $smsActivitiesApi->setCurl($this->getMockResponderCurl($expectedResponse));

        $responseSms = $activitiesApi->addSms($sms);

        $this->assertTrue($responseSms->getLocalPhone() === $sms->getLocalPhone());
        $this->assertNotEmpty($responseSms->getId());
    }

    public function testDeleteSms()
    {
        $activitiesApi = $this->closeIoApiWrapper->getActivitiesApi();

        $id = 'sms-to-be-deleted';

        $expectedResponse = new CloseIoResponse();
        $expectedResponse->setReturnCode('200');
        $expectedResponse->setCurlInfoRaw(['url' => $activitiesApi->getApiHandler()->getConfig()->getUrl() . $id]);

        $activitiesApi->setCurl($this->getMockResponderCurl($expectedResponse));

        $activitiesApi->deleteSms($id);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Curl
     * @description Need to be careful of the order, if method() comes after expects() it will return null
     */
    private function getMockResponderCurl($expectedResponse)
    {
        // create stub
        /** @var PHPUnit_Framework_MockObject_MockObject<Curl> $mockCurl */
        $mockCurl = $this->getMockBuilder('Curl')
            ->setMethods(['getResponse'])
            ->getMock();

        // configure the stub.
        $mockCurl->method('getResponse')->willReturn($expectedResponse);

        $mockCurl->expects($this->once())
            ->method('getResponse');

        return $mockCurl;
    }
}

