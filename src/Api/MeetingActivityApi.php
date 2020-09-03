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
use LooplineSystems\CloseIoApiWrapper\Model\MeetingActivity;

class MeetingActivityApi extends AbstractApi
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
            'get-meetings' => '/activity/meeting/',
            'get-meeting' => '/activity/meeting/[:id]/',
            'add-meeting' => '/activity/meeting/',
            'update-meeting' => '/activity/meeting/[:id]/',
            'delete-meeting' => '/activity/meeting/[:id]/',
        ];
    }

    /**
     * Gets up to the specified number of meeting activities that match the given
     * criteria.
     *
     * @param int      $offset  The offset from which start getting the items
     * @param int      $limit   The maximum number of items to get
     * @param array    $filters A set of criteria to filter the items by
     * @param string[] $fields  The subset of fields to get (defaults to all)
     *
     * @return MeetingActivity[]
     */
    public function list(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $filters = [], array $fields = []): array
    {
        /** @var MeetingActivity[] $activities */
        $activities = [];
        $response = $this->client->get($this->prepareUrlForKey('get-meetings'), array_merge($filters, [
            '_skip' => $offset,
            '_limit' => $limit,
            '_fields' => $fields,
        ]));

        $responseData = $response->getDecodedBody();

        foreach ($responseData['data'] as $activity) {
            $activities[] = new MeetingActivity($activity);
        }

        return $activities;
    }

    /**
     * Gets the information about the meeting activity that matches the given ID.
     *
     * @param string   $id     The ID of the activity
     * @param string[] $fields The subset of fields to get (defaults to all)
     *
     * @return MeetingActivity
     */
    public function get(string $id, array $fields = []): MeetingActivity
    {
        $response = $this->client->get($this->prepareUrlForKey('get-meeting', ['id' => $id]), ['_fields' => $fields]);

        return new MeetingActivity($response->getDecodedBody());
    }

    /**
     * Creates a new meeting activity using the given information.
     *
     * @param MeetingActivity $activity The information of the activity to create
     *
     * @return MeetingActivity
     */
    public function create(MeetingActivity $activity): MeetingActivity
    {
        $response = $this->client->post($this->prepareUrlForKey('add-meeting'), [], $activity->jsonSerialize());
        $responseData = $response->getDecodedBody();

        return new MeetingActivity($responseData);
    }

    /**
     * Updates the given meeting activity.
     *
     * @param MeetingActivity $activity The activity to update
     *
     * @return MeetingActivity
     */
    public function update(MeetingActivity $activity): MeetingActivity
    {
        $id = $activity->getId();

        $activity->setId(null);

        $response = $this->client->put($this->prepareUrlForKey('update-meeting', ['id' => $id]), [], $activity->jsonSerialize());
        $responseData = $response->getDecodedBody();

        return new MeetingActivity($responseData);
    }

    /**
     * Deletes the given meeting activity.
     *
     * @param MeetingActivity $activity The meeting activity to delete
     */
    public function delete(MeetingActivity $activity): void
    {
        $id = $activity->getId();

        $activity->setId(null);

        $this->client->delete($this->prepareUrlForKey('delete-meeting', ['id' => $id]));
    }
}
