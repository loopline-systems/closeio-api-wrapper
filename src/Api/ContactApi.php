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
use LooplineSystems\CloseIoApiWrapper\Model\Contact;

class ContactApi extends AbstractApi
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
            'get-contacts' => '/contact/',
            'add-contact' => '/contact/',
            'get-contact' => '/contact/[:id]/',
            'update-contact' => '/contact/[:id]/',
            'delete-contact' => '/contact/[:id]/',
        ];
    }

    /**
     * Gets up to the specified number of contacts that matches the given criteria.
     *
     * @param int      $offset The offset from which start getting the items
     * @param int      $limit  The maximum number of items to get
     * @param string[] $fields The subset of fields to get (defaults to all)
     *
     * @return Contact[]
     */
    public function list(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $fields = []): array
    {
        /** @var Contact[] $contacts */
        $contacts = [];
        $response = $this->client->get($this->prepareUrlForKey('get-contacts'), [
            '_skip' => $offset,
            '_limit' => $limit,
            '_fields' => $fields,
        ]);

        $responseData = $response->getDecodedBody();

        foreach ($responseData['data'] as $contact) {
            $contacts[] = new Contact($contact);
        }

        return $contacts;
    }

    /**
     * Gets the information about the contact that matches the given ID.
     *
     * @param string   $id     The ID of the contact
     * @param string[] $fields The subset of fields to get (defaults to all)
     *
     * @return Contact
     */
    public function get(string $id, array $fields = []): Contact
    {
        $response = $this->client->get($this->prepareUrlForKey('get-contact', ['id' => $id]), ['_fields' => $fields]);

        return new Contact($response->getDecodedBody());
    }

    /**
     * Creates a new contact using the given information.
     *
     * @param Contact $contact The information of the contact to create
     *
     * @return Contact
     */
    public function create(Contact $contact): Contact
    {
        $response = $this->client->post($this->prepareUrlForKey('add-contact'), $contact->jsonSerialize());
        $responseData = $response->getDecodedBody();

        return new Contact($responseData);
    }

    /**
     * Updates the given contact.
     *
     * @param Contact $contact The contact to update
     *
     * @return Contact
     */
    public function update(Contact $contact): Contact
    {
        $id = $contact->getId();

        $contact->setId(null);

        $response = $this->client->put($this->prepareUrlForKey('update-contact', ['id' => $id]), $contact->jsonSerialize());
        $responseData = $response->getDecodedBody();

        return new Contact($responseData);
    }

    /**
     * Deletes the given contact.
     *
     * @param Contact $contact The contact to delete
     */
    public function delete(Contact $contact): void
    {
        $id = $contact->getId();

        $contact->setId(null);

        $this->client->delete($this->prepareUrlForKey('delete-contact', ['id' => $id]));
    }

    /**
     * Gets all the contacts.
     *
     * @return Contact[]
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use list() instead
     */
    public function getAllContacts(): array
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use list() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->list();
    }

    /**
     * Gets the information about the contact that matches the given ID.
     *
     * @param string $contactId The ID of the contact
     *
     * @return Contact
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use get() instead
     */
    public function getContact($contactId): Contact
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use get() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->get($contactId);
    }

    /**
     * Creates a new contact using the given information.
     *
     * @param Contact $contact The information of the contact to create
     *
     * @return Contact
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use create() instead
     */
    public function addContact(Contact $contact): Contact
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use create() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->create($contact);
    }

    /**
     * Updates the given contact.
     *
     * @param Contact $contact The contact to update
     *
     * @return Contact
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use update() instead
     */
    public function updateContact(Contact $contact): Contact
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use update() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->update($contact);
    }

    /**
     * Deletes the given contact.
     *
     * @param string $id The ID of the contact to delete
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use delete() instead
     */
    public function deleteContact(string $id): void
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use delete() instead.', __METHOD__), E_USER_DEPRECATED);

        $this->client->delete($this->prepareUrlForKey('delete-contact', ['id' => $id]));
    }
}
