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
    private const MAX_ITEMS_PER_REQUEST = 50;

    const NAME = 'ActivityApi';

    /**
     * @description initialize the routes array
     */
    protected function initUrls()
    {
        $this->urls = [
            'get-activities' => '/activity/',
            'get-call' => '/activity/call/[:id]/',
            'delete-call' => '/activity/call/[:id]/',
            'add-note' => '/activity/note/',
            'get-notes' => '/activity/note/',
            'delete-note' => '/activity/note/[:id]/',
            'get-note' => '/activity/note/[:id]/',
            'update-note' => '/activity/note/[:id]/',
            'add-call' => '/activity/call/',
            'get-calls' => '/activity/call/',
            'add-email' => '/activity/email/',
            'get-emails' => '/activity/email/',
            'get-email' => '/activity/email/[:id]/',
            'update-email' => '/activity/email/[:id]/',
            'delete-email' => '/activity/email/[:id]/',
            'list-sms' => '/activity/sms/',
            'add-sms' => '/activity/sms/',
            'delete-sms' => '/activity/sms/[:id]/',
            'get-sms' => '/activity/sms/[:id]/',
            'update-sms' => '/activity/sms/[:id]/',
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
    public function getAll(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $filters = [], array $fields = []): array
    {
        /** @var Activity[] $activities */
        $activities = [];
        $result = $this->triggerGet(
            $this->prepareRequest('get-activities', null, [], array_merge($filters, [
                '_skip' => $offset,
                '_limit' => $limit,
                '_fields' => $fields,
            ]))
        );

        if (200 === $result->getReturnCode()) {
            $responseData = $result->getData();

            foreach ($responseData[CloseIoResponse::GET_RESPONSE_DATA_KEY] as $activity) {
                $activities[] = new Activity($activity);
            }
        }

        return $activities;
    }

    /**
     * Gets up to the specified number of call activities that match the given
     * criteria.
     *
     * @param int      $offset  The offset from which start getting the items
     * @param int      $limit   The maximum number of items to get
     * @param array    $filters A set of criteria to filter the items by
     * @param string[] $fields  The subset of fields to get (defaults to all)
     *
     * @return CallActivity[]
     */
    public function getAllCalls(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $filters = [], array $fields = []): array
    {
        /** @var CallActivity[] $activities */
        $activities = [];
        $result = $this->triggerGet(
            $this->prepareRequest('get-calls', null, [], array_merge($filters, [
                '_skip' => $offset,
                '_limit' => $limit,
                '_fields' => $fields,
            ]))
        );

        if (200 === $result->getReturnCode()) {
            $responseData = $result->getData();

            foreach ($responseData[CloseIoResponse::GET_RESPONSE_DATA_KEY] as $activity) {
                $activities[] = new CallActivity($activity);
            }
        }

        return $activities;
    }

    /**
     * Gets the information about the call activity that matches the given ID.
     *
     * @param string $id The ID of the activity
     *
     * @return CallActivity
     *
     * @throws ResourceNotFoundException If a call activity with the given ID
     *                                   doesn't exists
     */
    public function getCall(string $id): CallActivity
    {
        $result = $this->triggerGet($this->prepareRequest('get-call', null, ['id' => $id]));

        return new CallActivity($result->getData());
    }

    /**
     * Creates a new call activity using the given information.
     *
     * @param CallActivity $callActivity The information of the call activity
     *                                   to create
     *
     * @return CallActivity
     */
    public function createCall(CallActivity $callActivity): CallActivity
    {
        $apiRequest = $this->prepareRequest('add-call', json_encode($callActivity));

        return new CallActivity($this->triggerPost($apiRequest)->getData());
    }

    /**
     * Deletes the given call activity.
     *
     * @param string $callActivityId The ID of the call activity to delete
     *
     * @throws ResourceNotFoundException If a call activity with the given ID
     *                                   doesn't exists
     */
    public function deleteCall(string $callActivityId): void
    {
        $this->triggerDelete($this->prepareRequest('delete-call', null, ['id' => $callActivityId]));
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
    public function getAllEmails(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $filters = [], array $fields = []): array
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
                $activities[] = new CallActivity($activity);
            }
        }

        return $activities;
    }

    /**
     * Gets the information about the email activity that matches the given ID.
     *
     * @param string $id The ID of the activity
     *
     * @return EmailActivity
     *
     * @throws ResourceNotFoundException If an email activity with the given ID
     *                                   doesn't exists
     */
    public function getEmail(string $id): EmailActivity
    {
        $result = $this->triggerGet($this->prepareRequest('get-email', null, ['id' => $id]));

        return new EmailActivity($result->getData());
    }

    /**
     * Creates a new email activity using the given information.
     *
     * @param EmailActivity $activity The information of the email activity to
     *                                create
     *
     * @return EmailActivity
     */
    public function createEmail(EmailActivity $activity): EmailActivity
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
     * @throws ResourceNotFoundException If the activity with the given ID doesn't exists
     */
    public function updateEmail(EmailActivity $activity): EmailActivity
    {
        $id = $activity->getId();

        $activity->setId(null);

        $response = $this->triggerPut($this->prepareRequest('update-email', json_encode($activity), ['id' => $id]));

        return new EmailActivity($response->getData());
    }

    /**
     * Deletes the given email activity.
     *
     * @param string $activityId The ID of the email activity to delete
     *
     * @throws ResourceNotFoundException If a call activity with the given ID
     *                                   doesn't exists
     */
    public function deleteEmail(string $activityId): void
    {
        $this->triggerDelete($this->prepareRequest('delete-email', null, ['id' => $activityId]));
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
    public function getAllNotes(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $filters = [], array $fields = []): array
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
     * @param string $id The ID of the activity
     *
     * @return NoteActivity
     *
     * @throws ResourceNotFoundException If the activity with the given ID
     *                                   doesn't exists
     */
    public function getNote(string $id): NoteActivity
    {
        $result = $this->triggerGet($this->prepareRequest('get-note', null, ['id' => $id]));

        return new NoteActivity($result->getData());
    }

    /**
     * Creates a new note activity using the given information.
     *
     * @param NoteActivity $activity The information of the activity to create
     *
     * @return NoteActivity
     */
    public function createNote(NoteActivity $activity): NoteActivity
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
     */
    public function updateNote(NoteActivity $activity): NoteActivity
    {
        $id = $activity->getId();

        $activity->setId(null);

        $response = $this->triggerPut($this->prepareRequest('update-note', json_encode($activity), ['id' => $id]));

        return new NoteActivity($response->getData());
    }

    /**
     * Deletes the given note activity.
     *
     * @param string $activityId The ID of the note activity to delete
     *
     * @throws ResourceNotFoundException If the activity with the given ID
     *                                   doesn't exists
     */
    public function deleteNote(string $activityId): void
    {
        $this->triggerDelete($this->prepareRequest('delete-note', null, ['id' => $activityId]));
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
    public function getAllSms(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $filters = [], array $fields = []): array
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
     * @param string $id The ID of the activity
     *
     * @return SmsActivity
     *
     * @throws ResourceNotFoundException If the activity with the given ID
     *                                   doesn't exists
     */
    public function getSms(string $id): SmsActivity
    {
        $result = $this->triggerGet($this->prepareRequest('get-sms', null, ['id' => $id]));

        return new SmsActivity($result->getData());
    }

    /**
     * Creates a new SMS activity using the given information.
     *
     * @param SmsActivity $activity The information of the activity to create
     *
     * @return SmsActivity
     */
    public function createSms(SmsActivity $activity): SmsActivity
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
     */
    public function updateSms(SmsActivity $activity): SmsActivity
    {
        $id = $activity->getId();

        $activity->setId(null);

        $response = $this->triggerPut($this->prepareRequest('update-sms', json_encode($activity), ['id' => $id]));

        return new SmsActivity($response->getData());
    }

    /**
     * Deletes the given SMS activity.
     *
     * @param string $activityId The ID of the activity to delete
     *
     * @throws ResourceNotFoundException If the activity with the given ID
     *                                   doesn't exists
     */
    public function deleteSms(string $activityId): void
    {
        $this->triggerDelete($this->prepareRequest('delete-sms', null, ['id' => $activityId]));
    }

    /**
     * Creates a new note activity using the given information.
     *
     * @param NoteActivity $activity The information of the activity to create
     *
     * @return NoteActivity
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use createNote() instead.
     */
    public function addNote(NoteActivity $activity)
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use createNote() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->createNote($activity);
    }

    /**
     * Creates a new call activity using the given information.
     *
     * @param CallActivity $activity The information of the call activity to
     *                               create
     *
     * @return CallActivity
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use createCall() instead.
     */
    public function addCall(CallActivity $activity)
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use createCall() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->createCall($activity);
    }

    /**
     * Creates a new email activity using the given information.
     *
     * @param EmailActivity $activity The information of the email activity to
     *                                create
     *
     * @return EmailActivity
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use createEmail() instead.
     */
    public function addEmail(EmailActivity $activity)
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use createEmail() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->createEmail($activity);
    }

    /**
     * Creates a new SMS activity using the given information.
     *
     * @param SmsActivity $activity The information of the activity to create
     *
     * @return SmsActivity
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use createSms() instead.
     */
    public function addSms(SmsActivity $activity): SmsActivity
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use createSms() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->createSms($activity);
    }

    /**
     * Gets the note activities that match the given criteria.
     *
     * @param array $filters A set of criteria to filter the items by
     *
     * @return NoteActivity[]
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use getAllNotes() instead.
     */
    public function getNotes(array $filters): array
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use getAllNotes() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->getAllNotes(0, self::MAX_ITEMS_PER_REQUEST, $filters);
    }

    /**
     * Gets the call activities that match the given criteria.
     *
     * @param array $filters A set of criteria to filter the items by
     *
     * @return CallActivity[]
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use getAllCalls() instead.
     */
    public function getCalls(array $filters): array
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use getAllCalls() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->getAllCalls(0, self::MAX_ITEMS_PER_REQUEST, $filters);
    }

    /**
     * Gets the email activities that match the given criteria.
     *
     * @param array $filters A set of criteria to filter the items by
     *
     * @return EmailActivity[]
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use getAllEmails() instead.
     */
    public function getEmails(array $filters): array
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use getAllEmails() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->getAllEmails(0, self::MAX_ITEMS_PER_REQUEST, $filters);
    }

    /**
     * Gets the SMS activities that match the given criteria.
     *
     * @param array $filters A set of criteria to filter the items by
     *
     * @return SmsActivity[]
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use getAllSms() instead.
     */
    public function getSmss(array $filters): array
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use getAllSms() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->getAllSms(0, self::MAX_ITEMS_PER_REQUEST, $filters);
    }
}
