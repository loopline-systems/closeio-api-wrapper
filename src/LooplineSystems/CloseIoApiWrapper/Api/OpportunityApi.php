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
use LooplineSystems\CloseIoApiWrapper\Model\Opportunity;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException;

class OpportunityApi extends AbstractApi
{
    const NAME = 'OpportunityApi';

    /**
     * {@inheritdoc}
     */
    protected function initUrls()
    {
        $this->urls = [
            'get-opportunities' => '/opportunity/',
            'add-opportunity' => '/opportunity/',
            'get-opportunity' => '/opportunity/[:id]/',
            'update-opportunity' => '/opportunity/[:id]/',
            'delete-opportunity' => '/opportunity/[:id]/'
        ];
    }

    /**
     * @return Opportunity[]
     */
    public function getAllOpportunities()
    {
        /** @var Opportunity[] $opportunities */
        $opportunities = array();

        $apiRequest = $this->prepareRequest('get-opportunities');

        /** @var CloseIoResponse $result */
        $result = $this->triggerGet($apiRequest);

        if ($result->getReturnCode() == 200) {
            $rawData = $result->getData()[CloseIoResponse::GET_ALL_RESPONSE_LEADS_KEY];
            foreach ($rawData as $opportunity) {
                $opportunities[] = new Opportunity($opportunity);
            }
        }
        return $opportunities;
    }

    /**
     * @param $id
     * @return Opportunity
     * @throws ResourceNotFoundException
     */
    public function getOpportunity($id)
    {
        $apiRequest = $this->prepareRequest('get-opportunity', null, ['id' => $id]);

        /** @var CloseIoResponse $result */
        $result = $this->triggerGet($apiRequest);

        if ($result->getReturnCode() == 200 && ($result->getData() !== null)) {
            $opportunity = new Opportunity($result->getData());
        } else {
            throw new ResourceNotFoundException();
        }
        return $opportunity;
    }

    /**
     * @param Opportunity $opportunity
     * @return CloseIoResponse
     */
    public function addOpportunity(Opportunity $opportunity)
    {
        $this->validateOpportunityForPost($opportunity);

        $opportunity = json_encode($opportunity);
        $apiRequest = $this->prepareRequest('add-opportunity', $opportunity);
        return $this->triggerPost($apiRequest);
    }

    /**
     * @param Opportunity $opportunity
     * @return Opportunity|string
     * @throws InvalidParamException
     * @throws ResourceNotFoundException
     */
    public function updateOpportunity(Opportunity $opportunity)
    {
        // check if opportunity has id
        if ($opportunity->getId() == null) {
            throw new InvalidParamException('When updating a opportunity you must provide the opportunity ID');
        }
        // remove id from opportunity since it won't be part of the patch data
        $id = $opportunity->getId();
        $opportunity->setId(null);

        $opportunity = json_encode($opportunity);
        $apiRequest = $this->prepareRequest('update-opportunity', $opportunity, ['id' => $id]);
        $response = $this->triggerPut($apiRequest);

        // return Opportunity object if successful
        if ($response->getReturnCode() == 200 && ($response->getData() !== null)) {
            $opportunity = new Opportunity($response->getData());
        } else {
            throw new ResourceNotFoundException();
        }
        return $opportunity;
    }

    /**
     * @param $id
     * @return CloseIoResponse
     * @throws ResourceNotFoundException
     */
    public function deleteOpportunity($id){
        $apiRequest = $this->prepareRequest('delete-opportunity', null, ['id' => $id]);

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
     * @param Opportunity $opportunity
     * @return bool
     */
    public function validateOpportunityForPost(Opportunity $opportunity)
    {
        return true;
    }

}
