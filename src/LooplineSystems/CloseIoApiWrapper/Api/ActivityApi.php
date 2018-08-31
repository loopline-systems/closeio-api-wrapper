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

use LooplineSystems\CloseIoApiWrapper\ClientInterface;
use LooplineSystems\CloseIoApiWrapper\CloseIoApiWrapper;
use LooplineSystems\CloseIoApiWrapper\Library\Api\AbstractApi;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\BadApiRequestException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException;
use LooplineSystems\CloseIoApiWrapper\Model\Activity;
use LooplineSystems\CloseIoApiWrapper\Model\CallActivity;
use LooplineSystems\CloseIoApiWrapper\Model\EmailActivity;
use LooplineSystems\CloseIoApiWrapper\Model\NoteActivity;
use LooplineSystems\CloseIoApiWrapper\Model\SmsActivity;

class ActivityApi extends AbstractApi
{
    /**
     * The maximum number of items that are requested by default
     */
    private const MAX_ITEMS_PER_REQUEST = 100;

    /**
     * @var CloseIoApiWrapper
     */
    private $closeIoApiWrapper;

    public function __construct(ClientInterface $client, CloseIoApiWrapper $closeIoApiWrapper)
    {
        $this->closeIoApiWrapper = $closeIoApiWrapper;

        parent::__construct($client);
    }

    /**
     * @description initialize the routes array
     */
    protected function initUrls()
    {
        $this->urls = [
            'get-activities' => '/activity/',
            'delete-sms' => '/activity/sms/[:id]/',
        ];
    }

    /**
     * Gets up to the specified number of activities that match the given
     * criteria.
     *
     * @param int      $offset  The offset from which start getting the items
     * @param int      $limit   The maximum number of items to get
     * @param array    $filters A set of criteria to filter the items by
     * @param string[] $fields  The subset of fields to get (defaults to all)
     *
     * @return Activity[]
     */
    public function list(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $filters = [], array $fields = []): array
    {
        /** @var Activity[] $activities */
        $activities = [];
        $response = $this->client->get($this->prepareUrlForKey('get-activities'), array_merge($filters, [
            '_skip' => $offset,
            '_limit' => $limit,
            '_fields' => $fields,
        ]));

        if (200 === $response->getHttpStatusCode() && !$response->isError()) {
            $responseData = $response->getDecodedBody();

            foreach ($responseData['data'] as $activity) {
                $activities[] = new Activity($activity);
            }
        }

        return $activities;
    }

    /**
     * Creates a new note activity using the given information.
     *
     * @param NoteActivity $activity The information of the activity to create
     *
     * @return NoteActivity
     *
     * @throws BadApiRequestException If any error occurs during the request
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use NoteActivityApi::create() instead.
     */
    public function addNote(NoteActivity $activity)
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use NoteActivityApi::create() instead.', __METHOD__), E_USER_DEPRECATED);

        /** @var NoteActivityApi $apiHandler */
        $apiHandler = $this->closeIoApiWrapper->getNoteActivitiesApi();

        return $apiHandler->create($activity);
    }

    /**
     * Creates a new call activity using the given information.
     *
     * @param CallActivity $activity The information of the call activity to
     *                               create
     *
     * @return CallActivity
     *
     * @throws BadApiRequestException If any error occurs during the request
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use CallActivityApi::create() instead.
     */
    public function addCall(CallActivity $activity)
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use CallActivityApi::create() instead.', __METHOD__), E_USER_DEPRECATED);

        /** @var CallActivityApi $apiHandler */
        $apiHandler = $this->closeIoApiWrapper->getCallActivitiesApi();

        return $apiHandler->create($activity);
    }

    /**
     * Creates a new email activity using the given information.
     *
     * @param EmailActivity $activity The information of the email activity to
     *                                create
     *
     * @return EmailActivity
     *
     * @throws BadApiRequestException If any error occurs during the request
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use EmailActivityApi::create() instead.
     */
    public function addEmail(EmailActivity $activity)
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use EmailActivityApi::create() instead.', __METHOD__), E_USER_DEPRECATED);

        /** @var EmailActivityApi $apiHandler */
        $apiHandler = $this->closeIoApiWrapper->getEmailActivitiesApi();

        return $apiHandler->create($activity);
    }

    /**
     * Gets the note activities that match the given criteria.
     *
     * @param array $filters A set of criteria to filter the items by
     *
     * @return NoteActivity[]
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use NoteActivityApi::list() instead.
     */
    public function getNotes(array $filters): array
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use NoteActivityApi::list() instead.', __METHOD__), E_USER_DEPRECATED);

        /** @var NoteActivityApi $apiHandler */
        $apiHandler = $this->closeIoApiWrapper->getNoteActivitiesApi();

        return $apiHandler->list(0, self::MAX_ITEMS_PER_REQUEST, $filters);
    }

    /**
     * Gets the call activities that match the given criteria.
     *
     * @param array $filters A set of criteria to filter the items by
     *
     * @return CallActivity[]
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use CallActivityApi::list() instead.
     */
    public function getCalls(array $filters): array
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use CallActivityApi::list() instead.', __METHOD__), E_USER_DEPRECATED);

        /** @var CallActivityApi $apiHandler */
        $apiHandler = $this->closeIoApiWrapper->getCallActivitiesApi();

        return $apiHandler->list(0, self::MAX_ITEMS_PER_REQUEST, $filters);
    }

    /**
     * Gets the email activities that match the given criteria.
     *
     * @param array $filters A set of criteria to filter the items by
     *
     * @return EmailActivity[]
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use EmailActivityApi::list() instead.
     */
    public function getEmails(array $filters): array
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use EmailActivityApi::list() instead.', __METHOD__), E_USER_DEPRECATED);

        /** @var EmailActivityApi $apiHandler */
        $apiHandler = $this->closeIoApiWrapper->getEmailActivitiesApi();

        return $apiHandler->list(0, self::MAX_ITEMS_PER_REQUEST, $filters);
    }

    /**
     * Gets the SMS activities that match the given criteria.
     *
     * @param array $filters A set of criteria to filter the items by
     *
     * @return SmsActivity[]
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use SmsActivityApi::list() instead.
     */
    public function getSmss(array $filters): array
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use SmsActivityApi::list() instead.', __METHOD__), E_USER_DEPRECATED);

        /** @var SmsActivityApi $apiHandler */
        $apiHandler = $this->closeIoApiWrapper->getSmsActivitiesApi();

        return $apiHandler->list(0, self::MAX_ITEMS_PER_REQUEST, $filters);
    }

    /**
     * Gets the information about the SMS activity that matches the given ID.
     *
     * @param string $id The ID of the activity
     *
     * @return SmsActivity
     *
     * @throws ResourceNotFoundException If the activity with the given ID
     *                                   doesn't exists
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use SmsActivityApi::get() instead.
     */
    public function getSms(string $id): SmsActivity
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use SmsActivityApi::get() instead.', __METHOD__), E_USER_DEPRECATED);

        /** @var SmsActivityApi $apiHandler */
        $apiHandler = $this->closeIoApiWrapper->getSmsActivitiesApi();

        return $apiHandler->get($id);
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
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use SmsActivityApi::update() instead.
     */
    public function updateSms(SmsActivity $activity): SmsActivity
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use SmsActivityApi::update() instead.', __METHOD__), E_USER_DEPRECATED);

        /** @var SmsActivityApi $apiHandler */
        $apiHandler = $this->closeIoApiWrapper->getSmsActivitiesApi();

        return $apiHandler->update($activity);
    }

    /**
     * Creates a new SMS activity using the given information.
     *
     * @param SmsActivity $activity The information of the activity to create
     *
     * @return SmsActivity
     *
     * @throws BadApiRequestException If any error occurs during the request
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use SmsActivityApi::create() instead.
     */
    public function addSms(SmsActivity $activity): SmsActivity
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use SmsActivityApi::create() instead.', __METHOD__), E_USER_DEPRECATED);

        /** @var SmsActivityApi $apiHandler */
        $apiHandler = $this->closeIoApiWrapper->getSmsActivitiesApi();

        return $apiHandler->create($activity);
    }

    /**
     * Deletes the given SMS activity.
     *
     * @param string $activityId The ID of the activity to delete
     *
     * @throws ResourceNotFoundException If the activity with the given ID
     *                                   doesn't exists
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use SmsActivityApi::delete() instead.
     */
    public function deleteSms(string $activityId): void
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use SmsActivityApi::delete() instead.', __METHOD__), E_USER_DEPRECATED);

        $this->client->delete($this->prepareUrlForKey('delete-sms', ['id' => $activityId]));
    }
}
