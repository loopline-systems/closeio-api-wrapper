<?php

namespace LooplineSystems\CloseIoApiWrapper\Api;


use LooplineSystems\CloseIoApiWrapper\CloseIoResponse;
use LooplineSystems\CloseIoApiWrapper\Library\Api\AbstractApi;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException;
use LooplineSystems\CloseIoApiWrapper\Model\LeadStatus;

class LeadStatusApi extends AbstractApi
{
    const NAME = 'LeadStatusApi';

    /**
     * {@inheritdoc}
     */
    protected function initUrls()
    {
        $this->urls = [
            'get-statuses' => '/status/lead/',
            'add-status' => '/status/lead/',
            'get-status' => '/status/lead/[:id]/',
            'update-status' => '/status/lead/[:id]/',
            'delete-status' => '/status/lead/[:id]/'
        ];
    }

    /**
     * @param LeadStatus $status
     * @return LeadStatus
     */
    public function addStatus(LeadStatus $status)
    {
        $status = json_encode($status);
        $apiRequest = $this->prepareRequest('add-status', $status);
        $response = $this->triggerPost($apiRequest);
        return new LeadStatus($response->getData());
    }

    /**
     * @param LeadStatus $status
     * @return LeadStatus|string
     * @throws InvalidParamException
     * @throws ResourceNotFoundException
     */
    public function updateStatus(LeadStatus $status)
    {
        if ($status->getId() == null) {
            throw new InvalidParamException('When updating a status you must provide the statuses ID');
        }

        $id = $status->getId();
        $status->setId(null);

        $status = json_encode($status);
        $apiRequest = $this->prepareRequest('update-status', $status, ['id' => $id]);
        $response = $this->triggerPut($apiRequest);

        // return Lead object if successful
        if ($response->getReturnCode() == 200 && ($response->getData() !== null)) {
            $status = new LeadStatus($response->getData());
        } else {
            throw new ResourceNotFoundException();
        }
        return $status;
    }

    /**
     * @return LeadStatus[]
     */
    public function getAllStatus()
    {
        /** @var LeadStatus[] $statuses */
        $statuses = array();

        $apiRequest = $this->prepareRequest('get-statuses');

        /** @var CloseIoResponse $result */
        $result = $this->triggerGet($apiRequest);

        if ($result->getReturnCode() == 200) {
            $rawData = $result->getData()[CloseIoResponse::GET_ALL_RESPONSE_LEADS_KEY];
            foreach ($rawData as $status) {
                $statuses[] = new LeadStatus($status);
            }
        }
        return $statuses;
    }

    /**
     * @param $id
     * @return LeadStatus
     * @throws ResourceNotFoundException
     */
    public function getStatus($id)
    {
        $apiRequest = $this->prepareRequest('get-status', null, ['id' => $id]);

        /** @var CloseIoResponse $result */
        $result = $this->triggerGet($apiRequest);

        if ($result->getReturnCode() == 200 && ($result->getData() !== null)) {
            $status = new LeadStatus($result->getData());
        } else {
            throw new ResourceNotFoundException();
        }
        return $status;
    }

    /**
     * @param $id
     * @return CloseIoResponse
     * @throws ResourceNotFoundException
     */
    public function deleteStatus($id){
        $apiRequest = $this->prepareRequest('delete-status', null, ['id' => $id]);

        /** @var CloseIoResponse $result */
        $result = $this->triggerDelete($apiRequest);

        if ($result->getReturnCode() == 200) {
            return $result;
        } else {
            throw new ResourceNotFoundException();
        }
    }
}
