<?php

/**
 * Close.io Api Wrapper - LLS Internet GmbH - Loopline Systems.
 *
 * @see      https://github.com/loopline-systems/closeio-api-wrapper for the canonical source repository
 *
 * @copyright Copyright (c) 2014 LLS Internet GmbH - Loopline Systems (http://www.loopline-systems.com)
 * @license   https://github.com/loopline-systems/closeio-api-wrapper/blob/master/LICENSE (MIT Licence)
 */

declare(strict_types=1);

namespace LooplineSystems\CloseIoApiWrapper\Api;

use LooplineSystems\CloseIoApiWrapper\Library\Api\AbstractApi;
use LooplineSystems\CloseIoApiWrapper\Model\Opportunity;

class OpportunityApi extends AbstractApi
{
    /**
     * The maximum number of items that are requested by default.
     */
    private const MAX_ITEMS_PER_REQUEST = 100;

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
            'delete-opportunity' => '/opportunity/[:id]/',
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
    public function list(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $filters = [], array $fields = []): array
    {
        $params = [
            '_skip' => $offset,
            '_limit' => $limit,
            '_fields' => $fields,
        ];

        if (!empty($filters)) {
            $params['query'] = $this->buildQueryString($filters);
        }

        $opportunities = [];
        $response = $this->client->get($this->prepareUrlForKey('get-opportunities'), $params);

        $responseData = $response->getDecodedBody();

        foreach ($responseData['data'] as $opportunity) {
            $opportunities[] = new Opportunity($opportunity);
        }

        return $opportunities;
    }

    /**
     * Gets the information about the opportunity that matches the given ID.
     *
     * @param string   $id     The ID of the opportunity
     * @param string[] $fields The subset of fields to get (defaults to all)
     */
    public function get(string $id, array $fields = []): Opportunity
    {
        $response = $this->client->get($this->prepareUrlForKey('get-opportunity', ['id' => $id]), ['_fields' => $fields]);

        return new Opportunity($response->getDecodedBody());
    }

    /**
     * Creates a new opportunity using the given information.
     *
     * @param Opportunity $opportunity The information of the opportunity to
     *                                 create
     */
    public function create(Opportunity $opportunity): Opportunity
    {
        $response = $this->client->post($this->prepareUrlForKey('add-opportunity'), [], $opportunity->jsonSerialize());
        $responseData = $response->getDecodedBody();

        return new Opportunity($responseData);
    }

    /**
     * Updates the given opportunity.
     *
     * @param Opportunity $opportunity The opportunity to update
     */
    public function update(Opportunity $opportunity): Opportunity
    {
        $id = $opportunity->getId();

        $opportunity->setId(null);

        $response = $this->client->put($this->prepareUrlForKey('update-opportunity', ['id' => $id]), [], $opportunity->jsonSerialize());
        $responseData = $response->getDecodedBody();

        return new Opportunity($responseData);
    }

    /**
     * Deletes the given opportunity.
     *
     * @param Opportunity $opportunity The opportunity to delete
     */
    public function delete(Opportunity $opportunity): void
    {
        $id = $opportunity->getId();

        $opportunity->setId(null);

        $this->client->delete($this->prepareUrlForKey('delete-opportunity', ['id' => $id]));
    }

    /**
     * Gets all the opportunities.
     *
     * @return Opportunity[]
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use list() instead
     */
    public function getAllOpportunities(): array
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use list() instead.', __METHOD__), \E_USER_DEPRECATED);

        return $this->list();
    }

    /**
     * Gets the information about the opportunity that matches the given ID.
     *
     * @param string $opportunityId The ID of the opportunity
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use get() instead
     */
    public function getOpportunity($opportunityId): Opportunity
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use get() instead.', __METHOD__), \E_USER_DEPRECATED);

        return $this->get($opportunityId);
    }

    /**
     * Creates a new opportunity using the given information.
     *
     * @param Opportunity $opportunity The information of the opportunity to
     *                                 create
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use create() instead
     */
    public function addOpportunity(Opportunity $opportunity): Opportunity
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use create() instead.', __METHOD__), \E_USER_DEPRECATED);

        return $this->create($opportunity);
    }

    /**
     * Updates the given opportunity.
     *
     * @param Opportunity $opportunity The opportunity to update
     */
    public function updateOpportunity(Opportunity $opportunity): Opportunity
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use update() instead.', __METHOD__), \E_USER_DEPRECATED);

        return $this->update($opportunity);
    }

    /**
     * Deletes the given opportunity.
     *
     * @param string $id The ID of the opportunity to delete
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use delete() instead
     */
    public function deleteOpportunity(string $id): void
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use delete() instead.', __METHOD__), \E_USER_DEPRECATED);

        $this->client->delete($this->prepareUrlForKey('delete-opportunity', ['id' => $id]));
    }

    /**
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
