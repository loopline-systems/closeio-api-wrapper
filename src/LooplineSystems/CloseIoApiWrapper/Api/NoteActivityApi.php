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

use LooplineSystems\CloseIoApiWrapper\Library\Api\AbstractApi;
use LooplineSystems\CloseIoApiWrapper\Model\NoteActivity;

class NoteActivityApi extends AbstractApi
{
    /**
     * The maximum number of items that are requested by default
     */
    private const MAX_ITEMS_PER_REQUEST = 100;

    /**
     * {@inheritdoc}
     */
    protected function initUrls()
    {
        $this->urls = [
            'get-notes' => '/activity/note/',
            'get-note' => '/activity/note/[:id]/',
            'add-note' => '/activity/note/',
            'update-note' => '/activity/note/[:id]/',
            'delete-note' => '/activity/note/[:id]/',
        ];
    }

    /**
     * Gets up to the specified number of note activities that match the given
     * criteria.
     *
     * @param int      $offset  The offset from which start getting the items
     * @param int      $limit   The maximum number of items to get
     * @param array    $filters A set of criteria to filter the items by
     * @param string[] $fields  The subset of fields to get (defaults to all)
     *
     * @return NoteActivity[]
     */
    public function list(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $filters = [], array $fields = []): array
    {
        /** @var NoteActivity[] $activities */
        $activities = [];
        $response = $this->client->get($this->prepareUrlForKey('get-notes'), array_merge($filters, [
            '_skip' => $offset,
            '_limit' => $limit,
            '_fields' => $fields,
        ]));

        $responseData = $response->getDecodedBody();

        foreach ($responseData['data'] as $activity) {
            $activities[] = new NoteActivity($activity);
        }

        return $activities;
    }

    /**
     * Gets the information about the note activity that matches the given ID.
     *
     * @param string   $id     The ID of the activity
     * @param string[] $fields The subset of fields to get (defaults to all)
     *
     * @return NoteActivity
     */
    public function get(string $id, array $fields = []): NoteActivity
    {
        $response = $this->client->get($this->prepareUrlForKey('get-note', ['id' => $id]), ['_fields' => $fields]);

        return new NoteActivity($response->getDecodedBody());
    }

    /**
     * Creates a new note activity using the given information.
     *
     * @param NoteActivity $activity The information of the activity to create
     *
     * @return NoteActivity
     */
    public function create(NoteActivity $activity): NoteActivity
    {
        $response = $this->client->post($this->prepareUrlForKey('add-note'), $activity->jsonSerialize());
        $responseData = $response->getDecodedBody();

        return new NoteActivity($responseData);
    }

    /**
     * Updates the given note activity.
     *
     * @param NoteActivity $activity The activity to update
     *
     * @return NoteActivity
     */
    public function update(NoteActivity $activity): NoteActivity
    {
        $id = $activity->getId();

        $activity->setId(null);

        $response = $this->client->put($this->prepareUrlForKey('update-note', ['id' => $id]), $activity->jsonSerialize());
        $responseData = $response->getDecodedBody();

        return new NoteActivity($responseData);
    }

    /**
     * Deletes the given note activity.
     *
     * @param NoteActivity $activity The note activity to delete
     */
    public function delete(NoteActivity $activity): void
    {
        $id = $activity->getId();

        $activity->setId(null);

        $this->client->delete($this->prepareUrlForKey('delete-note', ['id' => $id]));
    }
}
