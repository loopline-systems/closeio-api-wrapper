<?php

declare(strict_types=1);

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
use LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException;
use LooplineSystems\CloseIoApiWrapper\Model\Opportunity;

class OpportunityApi extends AbstractApi
{
    /**
     * The maximum number of items that are requested by default
     */
    private const MAX_ITEMS_PER_REQUEST = 100;

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
     * Gets up to the specified number of opportunities that matches the given
     * criteria.
     *
     * @param int      $offset  The offset from which start getting the items
     * @param int      $limit   The maximum number of items to get
     * @param array    $filters A set of criteria to filter the items by
     * @param string[] $fields  The subset of fields to get (defaults to all)
     *
     * @return Opportunity[]
     */
    public function getAll(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $filters = [], array $fields = []): array
    {
        $params = [
            '_skip' => $offset,
            '_limit' => $limit,
            '_fields' => $fields,
        ];

        if (!empty($filters)) {
            $params['query'] = $this->buildQueryString($filters);
        }

        /** @var Opportunity[] $opportunities */
        $opportunities = [];
        $result = $this->triggerGet($this->prepareRequest('get-opportunities', null, [], $params));

        if (200 === $result->getReturnCode()) {
            $responseData = $result->getData();

            foreach ($responseData[CloseIoResponse::GET_RESPONSE_DATA_KEY] as $opportunity) {
                $opportunities[] = new Opportunity($opportunity);
            }
        }

        return $opportunities;
    }

    /**
     * Gets the information about the opportunity that matches the given ID.
     *
     * @param string   $id     The ID of the opportunity
     * @param string[] $fields The subset of fields to get (defaults to all)
     *
     * @return Opportunity
     *
     * @throws ResourceNotFoundException If a opportunity with the given ID
     *                                   doesn't exists
     */
    public function get(string $id, array $fields = []): Opportunity
    {
        $apiRequest = $this->prepareRequest('get-opportunity', null, ['id' => $id], ['_fields' => $fields]);

        return new Opportunity($this->triggerGet($apiRequest)->getData());
    }

    /**
     * Creates a new opportunity using the given information.
     *
     * @param Opportunity $opportunity The information of the opportunity to
     *                                 create
     *
     * @return Opportunity
     *
     * @throws BadApiRequestException    If the request contained invalid data
     */
    public function create(Opportunity $opportunity): Opportunity
    {
        $apiRequest = $this->prepareRequest('add-opportunity', json_encode($opportunity));

        return new Opportunity($this->triggerPost($apiRequest)->getData());
    }

    /**
     * Updates the given opportunity.
     *
     * @param Opportunity $opportunity The opportunity to update
     *
     * @return Opportunity
     *
     * @throws ResourceNotFoundException If a opportunity with the given ID
     *                                   doesn't exists
     * @throws BadApiRequestException    If the request contained invalid data
     */
    public function update(Opportunity $opportunity): Opportunity
    {
        $id = $opportunity->getId();

        $opportunity->setId(null);

        $response = $this->triggerPut($this->prepareRequest('update-opportunity', json_encode($opportunity), ['id' => $id]));

        return new Opportunity($response->getData());
    }

    /**
     * Deletes the given opportunity.
     *
     * @param Opportunity $opportunity The opportunity to delete
     *
     * @throws ResourceNotFoundException If the opportunity with the given ID
     *                                   doesn't exists
     * @throws BadApiRequestException    If the request contained invalid data
     */
    public function delete(Opportunity $opportunity): void
    {
        $id = $opportunity->getId();

        $opportunity->setId(null);

        $this->triggerDelete($this->prepareRequest('delete-opportunity', null, ['id' => $id]));
    }

    /**
     * Gets all the opportunities.
     *
     * @return Opportunity[]
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use getAll() instead
     */
    public function getAllOpportunities(): array
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use getAll() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->getAll();
    }

    /**
     * Gets the information about the opportunity that matches the given ID.
     *
     * @param string $opportunityId The ID of the opportunity
     *
     * @return Opportunity
     *
     * @throws ResourceNotFoundException If a opportunity with the given ID
     *                                   doesn't exists
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use get() instead
     */
    public function getOpportunity($opportunityId): Opportunity
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use get() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->get($opportunityId);
    }

    /**
     * Creates a new opportunity using the given information.
     *
     * @param Opportunity $opportunity The information of the opportunity to
     *                                 create
     *
     * @return Opportunity
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use create() instead
     */
    public function addOpportunity(Opportunity $opportunity): Opportunity
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use create() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->create($opportunity);
    }

    /**
     * Updates the given opportunity.
     *
     * @param Opportunity $opportunity The opportunity to update
     *
     * @return Opportunity
     *
     * @throws ResourceNotFoundException If a opportunity with the given ID
     *                                   doesn't exists
     */
    public function updateOpportunity(Opportunity $opportunity): Opportunity
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use update() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->update($opportunity);
    }

    /**
     * Deletes the given opportunity.
     *
     * @param string $opportunityId The ID of the opportunity to delete
     *
     * @throws ResourceNotFoundException If a opportunity with the given ID
     *                                   doesn't exists
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use delete() instead
     */
    public function deleteOpportunity(string $opportunityId): void
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use delete() instead.', __METHOD__), E_USER_DEPRECATED);

        $this->triggerDelete($this->prepareRequest('delete-opportunity', null, ['id' => $opportunityId]));
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
