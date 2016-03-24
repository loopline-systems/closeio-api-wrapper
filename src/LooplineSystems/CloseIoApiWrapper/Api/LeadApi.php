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
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidNewLeadPropertyException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;
use LooplineSystems\CloseIoApiWrapper\Model\Lead;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException;

class LeadApi extends AbstractApi
{
    const NAME = 'LeadApi';

    /**
     * {@inheritdoc}
     */
    protected function initUrls()
    {
        $this->urls = [
            'get-leads' => '/lead/',
            'add-lead' => '/lead/',
            'get-lead' => '/lead/[:id]/',
            'update-lead' => '/lead/[:id]/',
            'delete-lead' => '/lead/[:id]/'
        ];
    }

    /**
     * @return Lead[]
     */
    public function getAllLeads()
    {
        /** @var Lead[] $leads */
        $leads = array();

        $apiRequest = $this->prepareRequest('get-leads');

        /** @var CloseIoResponse $result */
        $result = $this->triggerGet($apiRequest);

        if ($result->getReturnCode() == 200) {
            $rawData = $result->getData()[CloseIoResponse::GET_RESPONSE_DATA_KEY];

            foreach ($rawData as $lead) {
                $leads[] = new Lead($lead);
            }
        }
        return $leads;
    }

    /**
     * @param array $queryParams
     *
     * @return Lead[]
     */
    public function findLeads(array $queryParams)
    {
        /** @var Lead[] $leads */
        $leads = array();
        if (count($queryParams) > 0) {
            $queryParams = ['query' => $this->buildQueryString($queryParams)];
        }
        $apiRequest = $this->prepareRequest('get-leads', '', [], $queryParams);
        /** @var CloseIoResponse $result */
        $result = $this->triggerGet($apiRequest);
        if ($result->getReturnCode() == 200) {
            $rawData = $result->getData()['data'];
            foreach ($rawData as $lead) {
                $leads[] = new Lead($lead);
            }
        }

        return $leads;
    }

    /**
     * @param array $params
     *
     * @return string
     */
    private function buildQueryString(array $params)
    {
        $flattened = [];
        foreach ($params as $key => $value) {
            $flattened[] = $key . '=' . $value;
        }
        $queryString = implode('&', $flattened);
        return $queryString;
    }

    /**
     * @param $id
     * @return Lead
     * @throws ResourceNotFoundException
     */
    public function getLead($id)
    {
        $apiRequest = $this->prepareRequest('get-lead', null, ['id' => $id]);

        /** @var CloseIoResponse $result */
        $result = $this->triggerGet($apiRequest);

        if ($result->getReturnCode() == 200 && ($result->getData() !== null)) {
            $lead = new Lead($result->getData());
        } else {
            throw new ResourceNotFoundException();
        }
        return $lead;
    }

    /**
     * @param Lead $lead
     * @return CloseIoResponse
     */
    public function addLead(Lead $lead)
    {
        $this->validateLeadForPost($lead);

        $lead = json_encode($lead);
        $apiRequest = $this->prepareRequest('add-lead', $lead);
        return $this->triggerPost($apiRequest);
    }

    /**
     * @param Lead $lead
     * @return Lead|string
     * @throws InvalidParamException
     * @throws ResourceNotFoundException
     */
    public function updateLead(Lead $lead)
    {
        // check if lead has id
        if ($lead->getId() == null) {
            throw new InvalidParamException('When updating a lead you must provide the lead ID');
        }
        // remove id from lead since it won't be part of the patch data
        $id = $lead->getId();
        $lead->setId(null);

        $lead = json_encode($lead);
        $apiRequest = $this->prepareRequest('update-lead', $lead, ['id' => $id]);
        $response = $this->triggerPut($apiRequest);

        // return Lead object if successful
        if ($response->getReturnCode() == 200 && ($response->getData() !== null)) {
            $lead = new Lead($response->getData());
        } else {
            throw new ResourceNotFoundException();
        }
        return $lead;
    }

    /**
     * @param $id
     * @return CloseIoResponse
     * @throws ResourceNotFoundException
     */
    public function deleteLead($id){
        $apiRequest = $this->prepareRequest('delete-lead', null, ['id' => $id]);

        /** @var CloseIoResponse $result */
        $result = $this->triggerDelete($apiRequest);

        if ($result->getReturnCode() == 200) {
            return $result;
        } else {
            throw new ResourceNotFoundException();
        }
    }

    /**
     * @param Curl $curl
     */
    public function setCurl($curl)
    {
        $this->curl = $curl;
    }

    /**
     * @param Lead $lead
     * @throws InvalidNewLeadPropertyException
     * @description Checks if lead does not contain invalid properties
     */
    public function validateLeadForPost(Lead $lead)
    {
        $invalidProperties = ['id', 'organization', 'tasks', 'opportunities'];
        foreach ($invalidProperties as $invalidProperty){
            $getter = 'get' . ucfirst($invalidProperty);
            if ($lead->$getter()){
                throw new InvalidNewLeadPropertyException('Cannot post ' . $invalidProperty . ' to new lead.');
            }
        }
    }

}
