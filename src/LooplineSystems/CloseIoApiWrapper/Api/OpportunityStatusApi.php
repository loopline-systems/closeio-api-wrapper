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
use LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException;
use LooplineSystems\CloseIoApiWrapper\Model\OpportunityStatus;

class OpportunityStatusApi extends AbstractApi
{
    /**
     * The maximum number of items that are requested by default
     */
    private const MAX_ITEMS_PER_REQUEST = 100;

    const NAME = 'OpportunityStatus';

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
            'delete-status' => '/status/opportunity/[:id]/'
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
    public function getAll(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $fields = []): array
    {
        /** @var OpportunityStatus[] $leadStatuses */
        $leadStatuses = [];
        $result = $this->triggerGet(
            $this->prepareRequest('get-statuses', null, [], [
                '_skip' => $offset,
                '_limit' => $limit,
                '_fields' => $fields,
            ])
        );

        if (200 === $result->getReturnCode()) {
            $responseData = $result->getData();

            foreach ($responseData[CloseIoResponse::GET_RESPONSE_DATA_KEY] as $leadStatus) {
                $leadStatuses[] = new OpportunityStatus($leadStatus);
            }
        }

        return $leadStatuses;
    }

    /**
     * Gets the information about the opportunity status that matches the given
     * ID.
     *
     * @param string   $id     The ID of the opportunityStatus
     * @param string[] $fields The subset of fields to get (defaults to all)
     *
     * @return OpportunityStatus
     *
     * @throws ResourceNotFoundException If an opportunity status with the given
     *                                   ID doesn't exists
     */
    public function get(string $id, array $fields = []): OpportunityStatus
    {
        $apiRequest = $this->prepareRequest('get-status', null, ['id' => $id], ['_fields' => $fields]);

        return new OpportunityStatus($this->triggerGet($apiRequest)->getData());
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
        $apiRequest = $this->prepareRequest('add-status', json_encode($opportunityStatus));

        return new OpportunityStatus($this->triggerPost($apiRequest)->getData());
    }

    /**
     * Updates the given opportunity status.
     *
     * @param OpportunityStatus $opportunityStatus The opportunity status to update
     *
     * @return OpportunityStatus
     *
     * @throws ResourceNotFoundException If an opportunity status with the given
     *                                   ID doesn't exists
     */
    public function update(OpportunityStatus $opportunityStatus): OpportunityStatus
    {
        $id = $opportunityStatus->getId();

        $opportunityStatus->setId(null);

        $response = $this->triggerPut($this->prepareRequest('update-status', json_encode($opportunityStatus), ['id' => $id]));

        return new OpportunityStatus($response->getData());
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

        $this->triggerDelete($this->prepareRequest('delete-status', null, ['id' => $id]));
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
     * @throws ResourceNotFoundException If an opportunity status with the given
     *                                   ID doesn't exists
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
     * @deprecated since version 0.8, to be removed in 0.9. Use getAll() instead
     */
    public function getAllStatus(): array
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use getAll() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->getAll();
    }

    /**
     * Gets the information about the opportunity status that matches the given
     * ID.
     *
     * @param string $opportunityStatusId The ID of the opportunityStatus
     *
     * @return OpportunityStatus
     *
     * @throws ResourceNotFoundException If an opportunity status with the given
     *                                   ID doesn't exists
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

        $this->triggerDelete($this->prepareRequest('delete-status', null, ['id' => $id]));
    }
}
