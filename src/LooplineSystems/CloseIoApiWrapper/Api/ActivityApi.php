<?php

namespace LooplineSystems\CloseIoApiWrapper\Api;

use LooplineSystems\CloseIoApiWrapper\CloseIoResponse;
use LooplineSystems\CloseIoApiWrapper\Library\Api\AbstractApi;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException;
use LooplineSystems\CloseIoApiWrapper\Model\Activity;
use LooplineSystems\CloseIoApiWrapper\Model\Call;
use LooplineSystems\CloseIoApiWrapper\Model\Lead;

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
            'get-note' => '/activity/note/[:id]/',
            'add-call' => '/activity/call/'
        ];
    }

    /**
     * @param Activity $activity
     *
     * @return CloseIoResponse
     */
    public function addNote(Activity $activity)
    {
        $this->validateActivityForPost($activity);

        $activity = json_encode($activity);
        $apiRequest = $this->prepareRequest('add-note', $activity);

        return $this->triggerPost($apiRequest);
    }

    /**
     * @param Call $call
     *
     * @return CloseIoResponse
     */
    public function addCall(Call $call)
    {
        $this->validateActivityForPost($call);

        $call = json_encode($call);
        $apiRequest = $this->prepareRequest('add-call', $call);

        return $this->triggerPost($apiRequest);
    }

    /**
     * @param $id
     *
     * @return Lead
     * @throws ResourceNotFoundException
     */
    public function getNote($id)
    {
        $apiRequest = $this->prepareRequest('get-note', null, ['id' => $id]);

        /** @var CloseIoResponse $result */
        $result = $this->triggerGet($apiRequest);

        if ($result->getReturnCode() == 200 && ($result->getData() !== null)) {
            return new Lead($result->getData());
        }

        throw new ResourceNotFoundException();
    }

    /**
     * @param $activity
     *
     * @return bool
     */
    private function validateActivityForPost($activity)
    {
        return true;
    }

}
