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
use LooplineSystems\CloseIoApiWrapper\Model\OpportunityStatus;

class OpportunityStatusApi extends AbstractApi
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
            'get-statuses' => '/status/opportunity/',
            'add-status' => '/status/opportunity/',
            'get-status' => '/status/opportunity/[:id]/',
            'update-status' => '/status/opportunity/[:id]/',
            'delete-status' => '/status/opportunity/[:id]/',
        ];
    }

    /**
     * Gets up to the specified number of opportunity statuses that match the
     * given criteria.
     *
     * @param int      $offset The offset from which start getting the items
     * @param int      $limit  The maximum number of items to get
     * @param string[] $fields The subset of fields to get (defaults to all)
     *
     * @return OpportunityStatus[]
     */
    public function list(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $fields = []): array
    {
        /** @var OpportunityStatus[] $opportunityStatuses */
        $opportunityStatuses = [];
        $response = $this->client->get($this->prepareUrlForKey('get-statuses'), [
            '_skip' => $offset,
            '_limit' => $limit,
            '_fields' => $fields,
        ]);

        $responseData = $response->getDecodedBody();

        foreach ($responseData['data'] as $opportunityStatus) {
            $opportunityStatuses[] = new OpportunityStatus($opportunityStatus);
        }

        return $opportunityStatuses;
    }

    /**
     * Gets the information about the opportunity status that matches the given
     * ID.
     *
     * @param string   $id     The ID of the opportunityStatus
     * @param string[] $fields The subset of fields to get (defaults to all)
     *
     * @return OpportunityStatus
     */
    public function get(string $id, array $fields = []): OpportunityStatus
    {
        $response = $this->client->get($this->prepareUrlForKey('get-status', ['id' => $id]), ['_fields' => $fields]);

        return new OpportunityStatus($response->getDecodedBody());
    }

    /**
     * Creates a new opportunity status using the given information.
     *
     * @param OpportunityStatus $opportunityStatus The opportunity status to create
     *
     * @return OpportunityStatus
     */
    public function create(OpportunityStatus $opportunityStatus): OpportunityStatus
    {
        $response = $this->client->post($this->prepareUrlForKey('add-status'), $opportunityStatus->jsonSerialize());
        $responseData = $response->getDecodedBody();

        return new OpportunityStatus($responseData);
    }

    /**
     * Updates the given opportunity status.
     *
     * @param OpportunityStatus $opportunityStatus The opportunity status to update
     *
     * @return OpportunityStatus
     */
    public function update(OpportunityStatus $opportunityStatus): OpportunityStatus
    {
        $id = $opportunityStatus->getId();

        $opportunityStatus->setId(null);

        $response = $this->client->put($this->prepareUrlForKey('update-status', ['id' => $id]), $opportunityStatus->jsonSerialize());
        $responseData = $response->getDecodedBody();

        return new OpportunityStatus($responseData);
    }

    /**
     * Deletes the given opportunity status.
     *
     * @param OpportunityStatus $opportunityStatus The opportunity status to delete
     */
    public function delete(OpportunityStatus $opportunityStatus): void
    {
        $id = $opportunityStatus->getId();

        $opportunityStatus->setId(null);

        $this->client->delete($this->prepareUrlForKey('delete-status', ['id' => $id]));
    }

    /**
     * Creates a new opportunity status using the given information.
     *
     * @param OpportunityStatus $opportunityStatus The opportunity status to create
     *
     * @return OpportunityStatus
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use create() instead
     */
    public function addStatus(OpportunityStatus $opportunityStatus): OpportunityStatus
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use create() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->create($opportunityStatus);
    }

    /**
     * Updates the given opportunity status.
     *
     * @param OpportunityStatus $opportunityStatus The opportunity status to update
     *
     * @return OpportunityStatus
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use update() instead
     */
    public function updateStatus(OpportunityStatus $opportunityStatus): OpportunityStatus
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use update() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->update($opportunityStatus);
    }

    /**
     * Gets all the opportunity statuses.
     *
     * @return OpportunityStatus[]
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use list() instead
     */
    public function getAllStatus(): array
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use list() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->list();
    }

    /**
     * Gets the information about the opportunity status that matches the given
     * ID.
     *
     * @param string $opportunityStatusId The ID of the opportunityStatus
     *
     * @return OpportunityStatus
     */
    public function getStatus($opportunityStatusId): OpportunityStatus
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use get() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->get($opportunityStatusId);
    }

    /**
     * Deletes the given opportunity status.
     *
     * @param string $id The ID of the opportunity status to delete
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use delete() instead
     */
    public function deleteStatus(string $id): void
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use delete() instead.', __METHOD__), E_USER_DEPRECATED);

        $this->client->delete($this->prepareUrlForKey('delete-status', ['id' => $id]));
    }
}
