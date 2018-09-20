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
use LooplineSystems\CloseIoApiWrapper\Model\NoteActivity;

class NoteActivityApi extends AbstractApi
{
    /**
     * The maximum number of items that are requested by default
     */
    private const MAX_ITEMS_PER_REQUEST = 100;

    const NAME = 'NoteActivityApi';

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
        $result = $this->triggerGet(
            $this->prepareRequest('get-notes', null, [], array_merge($filters, [
                '_skip' => $offset,
                '_limit' => $limit,
                '_fields' => $fields,
            ]))
        );

        if (200 === $result->getReturnCode()) {
            $responseData = $result->getData();

            foreach ($responseData[CloseIoResponse::GET_RESPONSE_DATA_KEY] as $activity) {
                $activities[] = new NoteActivity($activity);
            }
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
     *
     * @throws ResourceNotFoundException If the activity with the given ID
     *                                   doesn't exists
     */
    public function get(string $id, array $fields = []): NoteActivity
    {
        $apiRequest = $this->prepareRequest('get-note', null, ['id' => $id], ['_fields' => $fields]);

        return new NoteActivity($this->triggerGet($apiRequest)->getData());
    }

    /**
     * Creates a new note activity using the given information.
     *
     * @param NoteActivity $activity The information of the activity to create
     *
     * @return NoteActivity
     *
     * @throws BadApiRequestException
     */
    public function create(NoteActivity $activity): NoteActivity
    {
        $apiRequest = $this->prepareRequest('add-note', json_encode($activity));

        return new NoteActivity($this->triggerPost($apiRequest)->getData());
    }

    /**
     * Updates the given note activity.
     *
     * @param NoteActivity $activity The activity to update
     *
     * @return NoteActivity
     *
     * @throws ResourceNotFoundException If the activity with the given ID
     *                                   doesn't exists
     * @throws BadApiRequestException    If the request contained invalid data
     */
    public function update(NoteActivity $activity): NoteActivity
    {
        $id = $activity->getId();

        $activity->setId(null);

        $response = $this->triggerPut($this->prepareRequest('update-note', json_encode($activity), ['id' => $id]));

        return new NoteActivity($response->getData());
    }

    /**
     * Deletes the given note activity.
     *
     * @param NoteActivity $activity The note activity to delete
     *sms
     * @throws ResourceNotFoundException If the activity with the given ID
     *                                   doesn't exists
     */
    public function delete(NoteActivity $activity): void
    {
        $id = $activity->getId();

        $activity->setId(null);

        $this->triggerDelete($this->prepareRequest('delete-note', null, ['id' => $id]));
    }
}
