<?php

namespace LooplineSystems\CloseIoApiWrapper\Api;

use LooplineSystems\CloseIoApiWrapper\CloseIoResponse;
use LooplineSystems\CloseIoApiWrapper\Library\Api\AbstractApi;
use LooplineSystems\CloseIoApiWrapper\Model\Activity;
use LooplineSystems\CloseIoApiWrapper\Model\Call;

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
            'get-calls' => '/activity/call/'
        ];
    }

    /**
     * @param Activity $activity
     *
     * @return Activity
     */
    public function addNote(Activity $activity)
    {
        $activity = json_encode($activity);
        $apiRequest = $this->prepareRequest('add-note', $activity);

        $result = $this->triggerPost($apiRequest);

        return new Activity($result->getData());
    }

    /**
     * @param Call $call
     *
     * @return Call
     */
    public function addCall(Call $call)
    {
        $call = json_encode($call);
        $apiRequest = $this->prepareRequest('add-call', $call);

        $result = $this->triggerPost($apiRequest);

        return new Call($result->getData());
    }

    /**
     * @param array $filters
     *
     * @return array
     */
    public function getNotes(array $filters)
    {
        $apiRequest = $this->prepareRequest('get-notes', null, [], $filters);

        $result = $this->triggerGet($apiRequest);

        $rawData = $result->getData()[CloseIoResponse::GET_RESPONSE_DATA_KEY];
        $notes = [];
        foreach ($rawData as $note) {
            $notes[] = new Activity($note);
        }

        return $notes;
    }

    /**
     * @param array $filters
     *
     * @return array
     */
    public function getCalls(array $filters)
    {
        $apiRequest = $this->prepareRequest('get-calls', null, [], $filters);

        $result = $this->triggerGet($apiRequest);

        $rawData = $result->getData()[CloseIoResponse::GET_RESPONSE_DATA_KEY];
        $calls = [];
        foreach ($rawData as $call) {
            $calls[] = new Activity($call);
        }

        return $calls;
    }
}
