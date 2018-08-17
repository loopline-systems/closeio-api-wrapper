<?php declare(strict_types=1);
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
use LooplineSystems\CloseIoApiWrapper\Library\Exception\BadApiRequestException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\UrlNotSetException;
use LooplineSystems\CloseIoApiWrapper\Model\Opportunity;

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
     *
     * @throws BadApiRequestException
     * @throws InvalidParamException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function getAllOpportunities()
    {
        $opportunities = [];

        $apiRequest = $this->prepareRequest('get-opportunities');

        $result = $this->triggerGet($apiRequest);

        if ($result->getReturnCode() == 200) {
            $rawData = $result->getData()[CloseIoResponse::GET_RESPONSE_DATA_KEY];
            foreach ($rawData as $opportunity) {
                $opportunities[] = new Opportunity($opportunity);
            }
        }

        return $opportunities;
    }

    /**
     * @param string $id
     *
     * @return Opportunity
     *
     * @throws BadApiRequestException
     * @throws InvalidParamException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function getOpportunity($id)
    {
        $apiRequest = $this->prepareRequest('get-opportunity', null, ['id' => $id]);

        $result = $this->triggerGet($apiRequest);

        return new Opportunity($result->getData());
    }

    /**
     * @param Opportunity $opportunity
     *
     * @return Opportunity
     *
     * @throws BadApiRequestException
     * @throws InvalidParamException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function addOpportunity(Opportunity $opportunity)
    {
        $opportunity = json_encode($opportunity);
        $apiRequest = $this->prepareRequest('add-opportunity', $opportunity);

        $result = $this->triggerPost($apiRequest);

        return new Opportunity($result->getData());
    }

    /**
     * @param Opportunity $opportunity
     *
     * @return Opportunity
     *
     * @throws BadApiRequestException
     * @throws InvalidParamException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function updateOpportunity(Opportunity $opportunity)
    {
        if ($opportunity->getId() == null) {
            throw new InvalidParamException('When updating a opportunity you must provide the opportunity ID');
        }
        $id = $opportunity->getId();
        $opportunity->setId(null);

        $opportunity = json_encode($opportunity);
        $apiRequest = $this->prepareRequest('update-opportunity', $opportunity, ['id' => $id]);
        $response = $this->triggerPut($apiRequest);

        return new Opportunity($response->getData());
    }

    /**
     * @param string $id
     *
     * @return bool
     *
     * @throws InvalidParamException
     * @throws BadApiRequestException
     * @throws UrlNotSetException
     * @throws ResourceNotFoundException
     */
    public function deleteOpportunity($id){
        $apiRequest = $this->prepareRequest('delete-opportunity', null, ['id' => $id]);

        $response = $this->triggerDelete($apiRequest);

        return $response->isSuccess();
    }
}
