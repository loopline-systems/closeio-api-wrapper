<?php
/**
 * Created by PhpStorm.
 * User: dlima
 * Date: 3/7/16
 * Time: 2:22 PM
 */

namespace LooplineSystems\CloseIoApiWrapper\Api;


use LooplineSystems\CloseIoApiWrapper\CloseIoResponse;
use LooplineSystems\CloseIoApiWrapper\Library\Api\AbstractApi;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException;
use LooplineSystems\CloseIoApiWrapper\Model\LeadStatuses;

class LeadStatusesApi extends AbstractApi
{
    const NAME = 'LeadStatusesApi';

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
     * @param LeadStatuses $status
     * @return LeadStatuses
     */
    public function addStatus(LeadStatuses $status)
    {
        $status = json_encode($status);
        $apiRequest = $this->prepareRequest('add-status', $status);
        $response = $this->triggerPost($apiRequest);
        return new LeadStatuses($response->getData());
    }

    /**
     * @param LeadStatuses $status
     * @return LeadStatuses|string
     * @throws InvalidParamException
     * @throws ResourceNotFoundException
     */
    public function updateStatus(LeadStatuses $status)
    {
        if ($status->getStatusId() == null) {
            throw new InvalidParamException('When updating a status you must provide the statuses ID');
        }

        $id = $status->getStatusId();
        $status->setStatusId(null);

        $status = json_encode($status);
        $apiRequest = $this->prepareRequest('update-status', $status, ['id' => $id]);
        $response = $this->triggerPut($apiRequest);

        // return Lead object if successful
        if ($response->getReturnCode() == 200 && ($response->getData() !== null)) {
            $status = new LeadStatuses($response->getData());
        } else {
            throw new ResourceNotFoundException();
        }
        return $status;
    }

    /**
     * @return \LooplineSystems\CloseIoApiWrapper\Model\LeadStatuses[]
     */
    public function getAllStatus()
    {
        /** @var LeadStatuses[] $statuses */
        $statuses = array();

        $apiRequest = $this->prepareRequest('get-statuses');

        /** @var CloseIoResponse $result */
        $result = $this->triggerGet($apiRequest);

        if ($result->getReturnCode() == 200) {
            $rawData = $result->getData()[CloseIoResponse::GET_ALL_RESPONSE_LEADS_KEY];

            foreach ($rawData as $status) {
                $statuses[] = new LeadStatuses($status);
            }
        }
        return $statuses;
    }

    /**
     * @param $id
     * @return LeadStatuses
     * @throws ResourceNotFoundException
     */
    public function getStatus($id)
    {
        $apiRequest = $this->prepareRequest('get-status', null, ['id' => $id]);

        /** @var CloseIoResponse $result */
        $result = $this->triggerGet($apiRequest);

        if ($result->getReturnCode() == 200 && ($result->getData() !== null)) {
            $status = new LeadStatuses($result->getData());
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