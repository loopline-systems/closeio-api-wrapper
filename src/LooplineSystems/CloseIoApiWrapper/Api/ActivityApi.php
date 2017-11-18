<?php

namespace LooplineSystems\CloseIoApiWrapper\Api;

use LooplineSystems\CloseIoApiWrapper\CloseIoResponse;
use LooplineSystems\CloseIoApiWrapper\Library\Api\AbstractApi;
use LooplineSystems\CloseIoApiWrapper\Model\Activity;
use LooplineSystems\CloseIoApiWrapper\Model\CallActivity;
use LooplineSystems\CloseIoApiWrapper\Model\EmailActivity;
use LooplineSystems\CloseIoApiWrapper\Model\NoteActivity;

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
        ];
    }

    /**
     * @param NoteActivity $activity
     *
     * @return Activity
     */
    public function addNote(NoteActivity $activity)
    {
        $activity = json_encode($activity);
        $apiRequest = $this->prepareRequest('add-note', $activity);

        $result = $this->triggerPost($apiRequest);

        return new Activity($result->getData());
    }

    /**
     * @param CallActivity $call
     *
     * @return CallActivity
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
}
