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
use LooplineSystems\CloseIoApiWrapper\Library\Curl\Curl;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidNewLeadPropertyException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException;
use LooplineSystems\CloseIoApiWrapper\Model\Lead;

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
            'delete-lead' => '/lead/[:id]/',
        ];
    }

    /**
     * @return Lead[]
     */
    public function getAllLeads()
    {
        /** @var Lead[] $leads */
        $leads = [];

        $apiRequest = $this->prepareRequest('get-leads');

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
        $leads = [];
        if (count($queryParams) > 0) {
            $queryParams = ['query' => $this->buildQueryString($queryParams)];
        }
        $apiRequest = $this->prepareRequest('get-leads', '', [], $queryParams);

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
     * @param string $id
     *
     * @return Lead
     */
    public function getLead($id)
    {
        $apiRequest = $this->prepareRequest('get-lead', null, ['id' => $id]);

        $result = $this->triggerGet($apiRequest);

        return new Lead($result->getData());
    }

    /**
     * Converts Lead object to JSON. Also puts custom fields in newer, preferred, non-deprecated format.
     *
     * @param Lead $lead
     * @return String
     */
    private function encodeLead($lead)
    {
        // This slightly hacky encode/decode/encode is because of the requirement to put a period in the name of the
        // parameter, e.g. 'custom.FIELD_ID'. But it's not possible to do that while $lead is still a Lead object, as
        // PHP property names can't have periods in them.
        $lead = json_encode($lead);
        $lead = json_decode($lead, true);
        if(isset($lead['custom']) && is_array($lead['custom'])) {
            foreach ($lead['custom'] as $id => $value) {
                $fieldName = 'custom.' . $id;
                $lead[$fieldName] = $value;
            }
            unset($lead['custom']);
        }
        $lead = json_encode($lead);
        return $lead;
    }

    /**
     * @param Lead $lead
     *
     * @return Lead
     */
    public function addLead(Lead $lead)
    {
        $this->validateLeadForPost($lead);

        $lead = $this->encodeLead($lead);

        $apiRequest = $this->prepareRequest('add-lead', $lead);
        $response = $this->triggerPost($apiRequest);

        return new Lead($response->getData());
    }

    /**
     * @param Lead $lead
     *
     * @return Lead
     * @throws InvalidParamException
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

        $lead = $this->encodeLead($lead);

        $apiRequest = $this->prepareRequest('update-lead', $lead, ['id' => $id]);
        $response = $this->triggerPut($apiRequest);

        return new Lead($response->getData());
    }

    /**
     * @param string $id
     */
    public function deleteLead($id)
    {
        $apiRequest = $this->prepareRequest('delete-lead', null, ['id' => $id]);

        $this->triggerDelete($apiRequest);
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
     *
     * @throws InvalidNewLeadPropertyException
     */
    public function validateLeadForPost(Lead $lead)
    {
        $invalidProperties = ['id', 'organization', 'tasks', 'opportunities'];
        foreach ($invalidProperties as $invalidProperty) {
            $getter = 'get' . ucfirst($invalidProperty);
            if ($lead->$getter()) {
                throw new InvalidNewLeadPropertyException('Cannot post ' . $invalidProperty . ' to new lead.');
            }
        }
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
}
