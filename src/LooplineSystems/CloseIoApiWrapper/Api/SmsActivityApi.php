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
use LooplineSystems\CloseIoApiWrapper\Model\SmsActivity;

class SmsActivityApi extends AbstractApi
{
    /**
     * The maximum number of items that are requested by default
     */
    public const MAX_ITEMS_PER_REQUEST = 100;

    const NAME = 'SmsActivityApi';

    /**
     * {@inheritdoc}
     */
    protected function initUrls()
    {
        $this->urls = [
            'list-sms' => '/activity/sms/',
            'get-sms' => '/activity/sms/[:id]/',
            'add-sms' => '/activity/sms/',
            'update-sms' => '/activity/sms/[:id]/',
            'delete-sms' => '/activity/sms/[:id]/',
        ];
    }

    /**
     * Gets up to the specified number of SMS activities that match the given
     * criteria.
     *
     * @param int      $offset  The offset from which start getting the items
     * @param int      $limit   The maximum number of items to get
     * @param array    $filters A set of criteria to filter the items by
     * @param string[] $fields  The subset of fields to get (defaults to all)
     *
     * @return SmsActivity[]
     */
    public function getAll(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $filters = [], array $fields = []): array
    {
        /** @var SmsActivity[] $activities */
        $activities = [];
        $result = $this->triggerGet(
            $this->prepareRequest('list-sms', null, [], array_merge($filters, [
                '_skip' => $offset,
                '_limit' => $limit,
                '_fields' => $fields,
            ]))
        );

        if (200 === $result->getReturnCode()) {
            $responseData = $result->getData();

            foreach ($responseData[CloseIoResponse::GET_RESPONSE_DATA_KEY] as $activity) {
                $activities[] = new SmsActivity($activity);
            }
        }

        return $activities;
    }

    /**
     * Gets the information about the SMS activity that matches the given ID.
     *
     * @param string   $id     The ID of the activity
     * @param string[] $fields The subset of fields to get (defaults to all)
     *
     * @return SmsActivity
     *
     * @throws ResourceNotFoundException If the activity with the given ID
     *                                   doesn't exists
     */
    public function get(string $id, array $fields = []): SmsActivity
    {
        $apiRequest = $this->prepareRequest('get-sms', null, ['id' => $id], ['_fields' => $fields]);

        return new SmsActivity($this->triggerGet($apiRequest)->getData());
    }

    /**
     * Creates a new SMS activity using the given information.
     *
     * @param SmsActivity $activity The information of the activity to create
     *
     * @return SmsActivity
     *
     * @throws BadApiRequestException
     */
    public function create(SmsActivity $activity): SmsActivity
    {
        $apiRequest = $this->prepareRequest('add-sms', json_encode($activity));

        return new SmsActivity($this->triggerPost($apiRequest)->getData());
    }

    /**
     * Updates the given SMS activity.
     *
     * @param SmsActivity $activity The activity to update
     *
     * @return SmsActivity
     *
     * @throws ResourceNotFoundException If the activity with the given ID
     *                                   doesn't exists
     * @throws BadApiRequestException    If the request contained invalid data
     */
    public function update(SmsActivity $activity): SmsActivity
    {
        $id = $activity->getId();

        $activity->setId(null);

        $response = $this->triggerPut($this->prepareRequest('update-sms', json_encode($activity), ['id' => $id]));

        return new SmsActivity($response->getData());
    }

    /**
     * Deletes the given SMS activity.
     *
     * @param SmsActivity $activity The activity to delete
     *
     * @throws ResourceNotFoundException If the activity with the given ID
     *                                   doesn't exists
     * @throws BadApiRequestException    If the request contained invalid data
     */
    public function delete(SmsActivity $activity): void
    {
        $id = $activity->getId();

        $activity->setId(null);

        $this->triggerDelete($this->prepareRequest('delete-sms', null, ['id' => $id]));
    }
}
