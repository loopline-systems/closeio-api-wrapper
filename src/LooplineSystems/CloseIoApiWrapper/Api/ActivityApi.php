<?php
/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems
 *
 * @link      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

namespace LooplineSystems\CloseIoApiWrapper\Api;

use LooplineSystems\CloseIoApiWrapper\CloseIoResponse;
use LooplineSystems\CloseIoApiWrapper\Library\Api\AbstractApi;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\BadApiRequestException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\UrlNotSetException;
use LooplineSystems\CloseIoApiWrapper\Model\Activity;
use LooplineSystems\CloseIoApiWrapper\Model\CallActivity;
use LooplineSystems\CloseIoApiWrapper\Model\EmailActivity;
use LooplineSystems\CloseIoApiWrapper\Model\NoteActivity;
use LooplineSystems\CloseIoApiWrapper\Model\SmsActivity;

class ActivityApi extends AbstractApi
{
    const NAME = 'ActivityApi';

    /**
     * @description initialize the routes array
     */
    protected function initUrls()
    {
        $this->urls = [
            'add-note' => '/activity/note/',
            'get-notes' => '/activity/note/',
            'add-call' => '/activity/call/',
            'get-calls' => '/activity/call/',
            'add-email' => '/activity/email/',
            'get-emails' => '/activity/email/',
            'list-sms' => '/activity/sms/',
            'add-sms' => '/activity/sms/',
            'delete-sms' => '/activity/sms/[:id]',
            'get-sms' => '/activity/sms/[:id]',
        ];
    }
    /**
     * @param \LooplineSystems\CloseIoApiWrapper\Library\Curl\Curl $curl
     */
    public function setCurl($curl)
    {
        $this->curl = $curl;
    }

    /**
     * @param NoteActivity $activity
     *
     * @return Activity
     *
     * @throws BadApiRequestException
     * @throws InvalidParamException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function addNote(NoteActivity $activity)
    {
        $activity = json_encode($activity);
        $apiRequest = $this->prepareRequest('add-note', $activity);

        $result = $this->triggerPost($apiRequest);

        return new NoteActivity($result->getData());
    }

    /**
     * @param CallActivity $call
     *
     * @return CallActivity
     *
     * @throws BadApiRequestException
     * @throws InvalidParamException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function addCall(CallActivity $call)
    {
        $call = json_encode($call);
        $apiRequest = $this->prepareRequest('add-call', $call);

        $result = $this->triggerPost($apiRequest);

        return new CallActivity($result->getData());
    }

    /**
     * @param EmailActivity $email
     *
     * @return EmailActivity
     *
     * @throws BadApiRequestException
     * @throws InvalidParamException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function addEmail(EmailActivity $email)
    {
        $email = json_encode($email);
        $apiRequest = $this->prepareRequest('add-email', $email);

        $result = $this->triggerPost($apiRequest);

        return new EmailActivity($result->getData());
    }

    /**
     * @param array $filters
     *
     * @return NoteActivity[]
     *
     * @throws BadApiRequestException
     * @throws InvalidParamException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function getNotes(array $filters)
    {
        $apiRequest = $this->prepareRequest('get-notes', null, [], $filters);

        $result = $this->triggerGet($apiRequest);

        $rawData = $result->getData()[CloseIoResponse::GET_RESPONSE_DATA_KEY];
        $notes = [];
        foreach ($rawData as $note) {
            $notes[] = new NoteActivity($note);
        }

        return $notes;
    }

    /**
     * @param array $filters
     *
     * @return CallActivity[]
     *
     * @throws BadApiRequestException
     * @throws InvalidParamException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function getCalls(array $filters)
    {
        $apiRequest = $this->prepareRequest('get-calls', null, [], $filters);

        $result = $this->triggerGet($apiRequest);

        $rawData = $result->getData()[CloseIoResponse::GET_RESPONSE_DATA_KEY];
        $calls = [];
        foreach ($rawData as $call) {
            $calls[] = new CallActivity($call);
        }

        return $calls;
    }

    /**
     * @param array $filters
     *
     * @return EmailActivity[]
     *
     * @throws BadApiRequestException
     * @throws InvalidParamException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function getEmails(array $filters)
    {
        $apiRequest = $this->prepareRequest('get-emails', null, [], $filters);

        $result = $this->triggerGet($apiRequest);

        $rawData = $result->getData()[CloseIoResponse::GET_RESPONSE_DATA_KEY];
        $calls = [];
        foreach ($rawData as $call) {
            $calls[] = new EmailActivity($call);
        }

        return $calls;
    }

    /**
     * @param array $filters
     *
     * @return SmsActivity[]
     *
     * @throws BadApiRequestException
     * @throws InvalidParamException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function getSmss(array $filters)
    {
        $apiRequest = $this->prepareRequest('list-sms', null, [], $filters);

        $result = $this->triggerGet($apiRequest);

        $rawData = $result->getData()[CloseIoResponse::GET_RESPONSE_DATA_KEY];
        $list = [];
        foreach ($rawData as $sms) {
            $list[] = new SmsActivity($sms);
        }

        return $list;
    }

    /**
     * @param string $id
     *
     * @return SmsActivity
     *
     * @throws BadApiRequestException
     * @throws InvalidParamException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function getSms($id)
    {
        $apiRequest = $this->prepareRequest('get-sms', null, ['id' => $id]);

        $result = $this->triggerGet($apiRequest);

        return new SmsActivity($result->getData());
    }

    /**
     * @param SmsActivity $sms
     *
     * @return SmsActivity
     *
     * @throws BadApiRequestException
     * @throws InvalidParamException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function updateSms(SmsActivity $sms)
    {
        $id = $sms->getId();

        if (empty($id)) {
            throw new InvalidParamException('When updating a sms you must provide the sms ID');
        }

        // @see https://developer.close.io/#activities-update-an-sms-activity
        if (in_array($sms->getStatus(), [SmsActivity::STATUS_DRAFT, SmsActivity::STATUS_SCHEDULED])) {
            throw new InvalidParamException('When updating a sms it must have the status "draft" or "scheduled"');
        }

        $sms = json_encode($sms);
        $apiRequest = $this->prepareRequest('update-sms', $sms, ['id' => $id]);

        $result = $this->triggerPut($apiRequest);

        return new SmsActivity($result->getData());
    }

    /**
     * @param SmsActivity $sms
     *
     * @return SmsActivity
     *
     * @throws BadApiRequestException
     * @throws InvalidParamException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function addSms(SmsActivity $sms) {
        $sms = json_encode($sms);
        $apiRequest = $this->prepareRequest('add-sms', $sms);

        $result = $this->triggerPost($apiRequest);

        return new SmsActivity($result->getData());
    }

    /**
     * @param string $id
     *
     * @return bool
     *
     * @throws BadApiRequestException
     * @throws InvalidParamException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function deleteSms($id)
    {
        $apiRequest = $this->prepareRequest('delete-sms', null, ['id' => $id]);

        $result = $this->triggerDelete($apiRequest);

        return $result->isSuccess();
    }
}
