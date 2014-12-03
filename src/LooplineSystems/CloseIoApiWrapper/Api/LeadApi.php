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
            'get-lead' => '/lead/[:id]'
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
            $rawData = $result->getData()['data'];
            foreach ($rawData as $lead) {
                $leads[] = new Lead($lead);
            }
        }
        return $leads;
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
        $lead = json_encode($lead);
        $apiRequest = $this->prepareRequest('add-lead', $lead);
        return $this->triggerPost($apiRequest);
    }
}
