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
use LooplineSystems\CloseIoApiWrapper\Model\EmailActivity;

class EmailActivityApi extends AbstractApi
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
    public function list(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $filters = [], array $fields = []): array
    {
        /** @var EmailActivity[] $activities */
        $activities = [];
        $response = $this->client->get($this->prepareUrlForKey('get-emails'), array_merge($filters, [
            '_skip' => $offset,
            '_limit' => $limit,
            '_fields' => $fields,
        ]));

        $responseData = $response->getDecodedBody();

        foreach ($responseData['data'] as $activity) {
            $activities[] = new EmailActivity($activity);
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
     */
    public function get(string $id, array $fields = []): EmailActivity
    {
        $response = $this->client->get($this->prepareUrlForKey('get-email', ['id' => $id]), ['_fields' => $fields]);

        return new EmailActivity($response->getDecodedBody());
    }

    /**
     * Creates a new email activity using the given information.
     *
     * @param EmailActivity $activity The information of the email activity to
     *                                create
     *
     * @return EmailActivity
     */
    public function create(EmailActivity $activity): EmailActivity
    {
        $response = $this->client->post($this->prepareUrlForKey('add-email'), [], $activity->jsonSerialize());
        $responseData = $response->getDecodedBody();

        return new EmailActivity($responseData);
    }

    /**
     * Updates the given email activity.
     *
     * @param EmailActivity $activity The activity to update
     *
     * @return EmailActivity
     */
    public function update(EmailActivity $activity): EmailActivity
    {
        $id = $activity->getId();

        $activity->setId(null);

        $response = $this->client->put($this->prepareUrlForKey('update-email', ['id' => $id]), [], $activity->jsonSerialize());
        $responseData = $response->getDecodedBody();

        return new EmailActivity($responseData);
    }

    /**
     * Deletes the given email activity.
     *
     * @param EmailActivity $activity The email activity to delete
     */
    public function delete(EmailActivity $activity): void
    {
        $id = $activity->getId();

        $activity->setId(null);

        $this->client->delete($this->prepareUrlForKey('delete-email', ['id' => $id]));
    }
}
