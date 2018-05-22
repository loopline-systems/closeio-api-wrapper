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
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;
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
     *
     * @return LeadStatus
     * @throws InvalidParamException
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

        return new LeadStatus($response->getData());
    }

    /**
     * @return LeadStatus[]
     */
    public function getAllStatus()
    {
        $statuses = [];

        $apiRequest = $this->prepareRequest('get-statuses');

        $result = $this->triggerGet($apiRequest);

        if ($result->getReturnCode() == 200) {
            $rawData = $result->getData()[CloseIoResponse::GET_RESPONSE_DATA_KEY];
            foreach ($rawData as $status) {
                $statuses[] = new LeadStatus($status);
            }
        }
        return $statuses;
    }

    /**
     * @param string $id
     *
     * @return LeadStatus
     */
    public function getStatus($id)
    {
        $apiRequest = $this->prepareRequest('get-status', null, ['id' => $id]);

        /** @var CloseIoResponse $result */
        $result = $this->triggerGet($apiRequest);

        return new LeadStatus($result->getData());
    }

    /**
     * @param string $id
     */
    public function deleteStatus($id){
        $apiRequest = $this->prepareRequest('delete-status', null, ['id' => $id]);

        $this->triggerDelete($apiRequest);
    }
}
