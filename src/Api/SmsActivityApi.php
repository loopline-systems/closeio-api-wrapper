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
use LooplineSystems\CloseIoApiWrapper\Model\SmsActivity;

class SmsActivityApi extends AbstractApi
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
    public function list(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $filters = [], array $fields = []): array
    {
        /** @var SmsActivity[] $activities */
        $activities = [];
        $response = $this->client->get($this->prepareUrlForKey('list-sms'), array_merge($filters, [
            '_skip' => $offset,
            '_limit' => $limit,
            '_fields' => $fields,
        ]));

        $responseData = $response->getDecodedBody();

        foreach ($responseData['data'] as $activity) {
            $activities[] = new SmsActivity($activity);
        }

        return $activities;
    }

    /**
     * Gets the information about the SMS activity that matches the given ID.
     *
     * @param string   $id     The ID of the activity
     * @param string[] $fields The subset of fields to get (defaults to all)
     */
    public function get(string $id, array $fields = []): SmsActivity
    {
        $response = $this->client->get($this->prepareUrlForKey('get-sms', ['id' => $id]), ['_fields' => $fields]);

        return new SmsActivity($response->getDecodedBody());
    }

    /**
     * Creates a new SMS activity using the given information.
     *
     * @param SmsActivity $activity The information of the activity to create
     */
    public function create(SmsActivity $activity): SmsActivity
    {
        $response = $this->client->post($this->prepareUrlForKey('add-sms'), [], $activity->jsonSerialize());
        $responseData = $response->getDecodedBody();

        return new SmsActivity($responseData);
    }

    /**
     * Updates the given SMS activity.
     *
     * @param SmsActivity $activity The activity to update
     */
    public function update(SmsActivity $activity): SmsActivity
    {
        $id = $activity->getId();

        $activity->setId(null);

        $response = $this->client->put($this->prepareUrlForKey('update-sms', ['id' => $id]), [], $activity->jsonSerialize());
        $responseData = $response->getDecodedBody();

        return new SmsActivity($responseData);
    }

    /**
     * Deletes the given SMS activity.
     *
     * @param SmsActivity $activity The activity to delete
     */
    public function delete(SmsActivity $activity): void
    {
        $id = $activity->getId();

        $activity->setId(null);

        $this->client->delete($this->prepareUrlForKey('delete-sms', ['id' => $id]));
    }
}
