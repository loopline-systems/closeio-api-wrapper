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
use LooplineSystems\CloseIoApiWrapper\Model\EmailActivity;

class EmailActivityApi extends AbstractApi
{
    /**
     * The maximum number of items that are requested by default
     */
    public const MAX_ITEMS_PER_REQUEST = 100;

    const NAME = 'EmailActivityApi';

    /**
     * {@inheritdoc}
     */
    protected function initUrls()
    {
        $this->urls = [
            'get-emails' => '/activity/email/',
            'get-email' => '/activity/email/[:id]/',
            'add-email' => '/activity/email/',
            'update-email' => '/activity/email/[:id]/',
            'delete-email' => '/activity/email/[:id]/',
        ];
    }

    /**
     * Gets up to the specified number of email activities that match the given
     * criteria.
     *
     * @param int      $offset  The offset from which start getting the items
     * @param int      $limit   The maximum number of items to get
     * @param array    $filters A set of criteria to filter the items by
     * @param string[] $fields  The subset of fields to get (defaults to all)
     *
     * @return EmailActivity[]
     */
    public function getAll(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $filters = [], array $fields = []): array
    {
        /** @var EmailActivity[] $activities */
        $activities = [];
        $result = $this->triggerGet(
            $this->prepareRequest('get-emails', null, [], array_merge($filters, [
                '_skip' => $offset,
                '_limit' => $limit,
                '_fields' => $fields,
            ]))
        );

        if (200 === $result->getReturnCode()) {
            $responseData = $result->getData();

            foreach ($responseData[CloseIoResponse::GET_RESPONSE_DATA_KEY] as $activity) {
                $activities[] = new EmailActivity($activity);
            }
        }

        return $activities;
    }

    /**
     * Gets the information about the email activity that matches the given ID.
     *
     * @param string   $id     The ID of the activity
     * @param string[] $fields The subset of fields to get (defaults to all)
     *
     * @return EmailActivity
     *
     * @throws ResourceNotFoundException If an email activity with the given ID
     *                                   doesn't exists
     */
    public function get(string $id, array $fields = []): EmailActivity
    {
        $apiRequest = $this->prepareRequest('get-email', null, ['id' => $id], ['_fields' => $fields]);

        return new EmailActivity($this->triggerGet($apiRequest)->getData());
    }

    /**
     * Creates a new email activity using the given information.
     *
     * @param EmailActivity $activity The information of the email activity to
     *                                create
     *
     * @return EmailActivity
     *
     * @throws BadApiRequestException
     */
    public function create(EmailActivity $activity): EmailActivity
    {
        $apiRequest = $this->prepareRequest('add-email', json_encode($activity));

        return new EmailActivity($this->triggerPost($apiRequest)->getData());
    }

    /**
     * Updates the given email activity.
     *
     * @param EmailActivity $activity The activity to update
     *
     * @return EmailActivity
     *
     * @throws ResourceNotFoundException If the activity with the given ID
     *                                   doesn't exists
     * @throws BadApiRequestException    If the request contained invalid data
     */
    public function update(EmailActivity $activity): EmailActivity
    {
        $id = $activity->getId();

        $activity->setId(null);

        $response = $this->triggerPut($this->prepareRequest('update-email', json_encode($activity), ['id' => $id]));

        return new EmailActivity($response->getData());
    }

    /**
     * Deletes the given email activity.
     *
     * @param EmailActivity $activity The email activity to delete
     *
     * @throws ResourceNotFoundException If a call activity with the given ID
     *                                   doesn't exists
     */
    public function delete(EmailActivity $activity): void
    {
        $id = $activity->getId();

        $activity->setId(null);

        $this->triggerDelete($this->prepareRequest('delete-email', null, ['id' => $id]));
    }
}
