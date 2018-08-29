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
use LooplineSystems\CloseIoApiWrapper\Model\LeadStatus;

class LeadStatusApi extends AbstractApi
{
    /**
     * The maximum number of items that are requested by default
     */
    private const MAX_ITEMS_PER_REQUEST = 50;

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
     * Gets up to the specified number of lead statuses that match the given
     * criteria.
     *
     * @param int   $offset The offset from which start getting the items
     * @param int   $limit  The maximum number of items to get
     * @param string[] $fields The subset of fields to get (defaults to all)
     *
     * @return LeadStatus[]
     */
    public function getAll(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $fields = []): array
    {
        /** @var LeadStatus[] $leadStatuses */
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
                $leadStatuses[] = new LeadStatus($leadStatus);
            }
        }

        return $leadStatuses;
    }

    /**
     * Gets the information about the lead status that matches the given ID.
     *
     * @param string $leadStatusId The ID of the leadStatus
     *
     * @return LeadStatus
     *
     * @throws ResourceNotFoundException If a leadStatus with the given ID doesn't
     *                                   exists
     */
    public function get(string $leadStatusId): LeadStatus
    {
        $result = $this->triggerGet($this->prepareRequest('get-status', null, ['id' => $leadStatusId]));

        return new LeadStatus($result->getData());
    }

    /**
     * Creates a new lead status using the given information.
     *
     * @param LeadStatus $leadStatus The information of the leadStatus to create
     *
     * @return LeadStatus
     */
    public function create(LeadStatus $leadStatus): LeadStatus
    {
        $apiRequest = $this->prepareRequest('add-status', json_encode($leadStatus));

        return new LeadStatus($this->triggerPost($apiRequest)->getData());
    }

    /**
     * Updates the given lead status.
     *
     * @param LeadStatus $leadStatus The leadStatus to update
     *
     * @return LeadStatus
     *
     * @throws ResourceNotFoundException If a leadStatus with the given ID doesn't
     *                                   exists
     */
    public function update(LeadStatus $leadStatus): LeadStatus
    {
        $id = $leadStatus->getId();

        $leadStatus->setId(null);

        $response = $this->triggerPut($this->prepareRequest('update-status', json_encode($leadStatus), ['id' => $id]));

        return new LeadStatus($response->getData());
    }

    /**
     * Deletes the given lead status.
     *
     * @param string $leadStatusId The ID of the leadStatus to delete
     *
     * @throws ResourceNotFoundException If a leadStatus with the given ID doesn't
     *                                   exists
     */
    public function delete(string $leadStatusId): void
    {
        $this->triggerDelete($this->prepareRequest('delete-status', null, ['id' => $leadStatusId]));
    }

    /**
     * Creates a new lead status using the given information.
     *
     * @param LeadStatus $leadStatus The information of the leadStatus to create
     *
     * @return LeadStatus
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use create() instead
     */
    public function addStatus(LeadStatus $leadStatus): LeadStatus
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use create() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->create($leadStatus);
    }

    /**
     * Updates the given lead status.
     *
     * @param LeadStatus $leadStatus The leadStatus to update
     *
     * @return LeadStatus
     *
     * @throws ResourceNotFoundException If a leadStatus with the given ID doesn't
     *                                   exists
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use update() instead
     */
    public function updateStatus(LeadStatus $leadStatus): LeadStatus
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use update() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->update($leadStatus);
    }

    /**
     * Gets all the lead statuses.
     *
     * @return LeadStatus[]
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use getAll() instead
     */
    public function getAllStatus(): array
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use getAll() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->getAll();
    }

    /**
     * Gets the information about the lead status that matches the given ID.
     *
     * @param string $leadStatusId The ID of the leadStatus
     *
     * @return LeadStatus
     *
     * @throws ResourceNotFoundException If a leadStatus with the given ID doesn't
     *                                   exists
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use get() instead
     */
    public function getStatus(string $leadStatusId): LeadStatus
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use get() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->get($leadStatusId);
    }

    /**
     * Deletes the given lead status.
     *
     * @param string $leadStatusId The ID of the leadStatus to delete
     *
     * @throws ResourceNotFoundException If a leadStatus with the given ID doesn't
     *                                   exists
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use delete() instead
     */
    public function deleteStatus(string $leadStatusId): void
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use delete() instead.', __METHOD__), E_USER_DEPRECATED);

        $this->delete($leadStatusId);
    }
}
