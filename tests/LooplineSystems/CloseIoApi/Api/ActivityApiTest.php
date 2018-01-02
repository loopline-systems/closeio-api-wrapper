<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper\Tests;

use LooplineSystems\CloseIoApiWrapper\Api\ActivityApi;
use LooplineSystems\CloseIoApiWrapper\CloseIoApiWrapper;
use LooplineSystems\CloseIoApiWrapper\CloseIoConfig;
use LooplineSystems\CloseIoApiWrapper\CloseIoResponse;
use LooplineSystems\CloseIoApiWrapper\Library\Curl\Curl;
use LooplineSystems\CloseIoApiWrapper\Model\SmsActivity;

class ActivityApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @description tests updating a sms activity using mock curl object
     *
     * @throws \LooplineSystems\CloseIoApiWrapper\Library\Exception\ApiNotFoundException
     */
    public function testUpdateSms()
    {
        $sms = new SmsActivity();
        $sms->setId('test-124');
        $sms->setLocalPhone('+123456789');

        $activityApi = $this->getActivityApi();

        $returnedSms = clone $sms;

        $expectedResponse = new CloseIoResponse();
        $expectedResponse->setReturnCode(201);
        $expectedResponse->setRawData(json_encode($returnedSms));
        $expectedResponse->setData(json_decode($expectedResponse->getRawData(), true));

        $activityApi->setCurl($this->getMockResponderCurl($expectedResponse));

        $responseSms = $activityApi->addSms($sms);

        $this->assertTrue($responseSms->getLocalPhone() === $sms->getLocalPhone());
        $this->assertNotEmpty($responseSms->getId());
    }

    public function testDeleteSms()
    {
        $activityApi = $this->getActivityApi();

        $id = 'sms-to-be-deleted';

        // init expected response
        $expectedResponse = new CloseIoResponse();
        $expectedResponse->setReturnCode('200');
        $expectedResponse->setCurlInfoRaw(['url' => $activityApi->getApiHandler()->getConfig()->getUrl() . $id]);

        // create stub
        $mockCurl = $this->getMockResponderCurl($expectedResponse);
        $activityApi->setCurl($mockCurl);

        $this->assertTrue($activityApi->deleteSms($id), 'should return true on delete');
    }

    /**
     * @return ActivityApi
     */
    private function getActivityApi()
    {
        // init wrapper
        $closeIoConfig = new CloseIoConfig();
        $closeIoConfig->setApiKey('testapikey');
        $closeIoApiWrapper = new CloseIoApiWrapper($closeIoConfig);

        return $closeIoApiWrapper->getActivitiesApi();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Curl
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
}

