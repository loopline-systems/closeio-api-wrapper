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
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidNewLeadPropertyException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;
use LooplineSystems\CloseIoApiWrapper\Model\Lead;

class LeadApi extends AbstractApi
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
            'get-leads' => '/lead/',
            'add-lead' => '/lead/',
            'get-lead' => '/lead/[:id]/',
            'update-lead' => '/lead/[:id]/',
            'delete-lead' => '/lead/[:id]/',
            'merge-leads' => '/lead/merge/',
        ];
    }

    /**
     * Gets up to the specified number of leads that matches the given criteria.
     *
     * @param int      $offset  The offset from which start getting the items
     * @param int      $limit   The maximum number of items to get
     * @param array    $filters A set of criteria to filter the items by
     * @param string[] $fields  The subset of fields to get (defaults to all)
     *
     * @return Lead[]
     */
    public function list(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $filters = [], array $fields = []): array
    {
        /** @var Lead[] $leads */
        $leads = [];
        $response = $this->client->get($this->prepareUrlForKey('get-leads'), array_merge($filters, [
            '_skip' => $offset,
            '_limit' => $limit,
            '_fields' => $fields,
        ]));

        $responseData = $response->getDecodedBody();

        foreach ($responseData['data'] as $lead) {
            $leads[] = new Lead($lead);
        }

        return $leads;
    }

    /**
     * Gets the information about the lead that matches the given ID.
     *
     * @param string   $id     The ID of the lead
     * @param string[] $fields The subset of fields to get (defaults to all)
     *
     * @return Lead
     */
    public function get(string $id, array $fields = []): Lead
    {
        $response = $this->client->get($this->prepareUrlForKey('get-lead', ['id' => $id]), ['_fields' => $fields]);

        return new Lead($response->getDecodedBody());
    }

    /**
     * Creates a new lead using the given information.
     *
     * @param Lead $lead The information of the lead to create
     *
     * @return Lead
     *
     * @throws InvalidNewLeadPropertyException
     */
    public function create(Lead $lead): Lead
    {
        $this->validateLeadForPost($lead);

        $response = $this->client->post($this->prepareUrlForKey('add-lead'), $lead->jsonSerialize());
        $responseData = $response->getDecodedBody();

        return new Lead($responseData);
    }

    /**
     * Updates the given lead.
     *
     * @param Lead $lead The lead to update
     *
     * @return Lead
     */
    public function update(Lead $lead): Lead
    {
        $id = $lead->getId();

        $lead->setId(null);

        $response = $this->client->put($this->prepareUrlForKey('update-lead', ['id' => $id]), $lead->jsonSerialize());
        $responseData = $response->getDecodedBody();

        return new Lead($responseData);
    }

    /**
     * Deletes the given lead.
     *
     * @param Lead $lead The lead to delete
     */
    public function delete(Lead $lead): void
    {
        $id = $lead->getId();

        $lead->setId(null);

        $this->client->delete($this->prepareUrlForKey('delete-lead', ['id' => $id]));
    }

    /**
     * Merges two leads.
     *
     * @param Lead $source      The source lead (he will be deleted afterwards)
     * @param Lead $destination The lead to merge the data in
     *
     * @throws InvalidParamException If any of the two leads have an invalid ID
     */
    public function merge(Lead $source, Lead $destination): void
    {
        if (empty($source->getId()) || empty($destination->getId())) {
            throw new InvalidParamException('You need to specify two already existing leads in order to merge them');
        }

        $this->client->post($this->prepareUrlForKey('merge-leads'), [
            'destination' => $destination->getId(),
            'source' => $source->getId(),
        ]);
    }

    /**
     * Gets all the leads.
     *
     * @return Lead[]
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use list() instead.
     */
    public function getAllLeads(): array
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use list() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->list();
    }

    /**
     * Get all the leads that match the given criteria.
     *
     * @param array $queryParams The search criteria
     *
     * @return Lead[]
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use list() instead.
     */
    public function findLeads(array $queryParams): array
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use list() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->list(0, self::MAX_ITEMS_PER_REQUEST, $queryParams);
    }

    /**
     * Gets the lead with the given ID.
     *
     * @param string $id The ID of the lead
     *
     * @return Lead
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use get() instead.
     */
    public function getLead(string $id): Lead
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use get() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->get($id);
    }

    /**
     * Creates a new lead using the given information.
     *
     * @param Lead $lead The information of the lead to create
     *
     * @return Lead
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use create() instead
     */
    public function addLead(Lead $lead): Lead
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use create() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->create($lead);
    }

    /**
     * Updates the given lead.
     *
     * @param Lead $lead The lead to update
     *
     * @return Lead
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use update() instead
     */
    public function updateLead(Lead $lead): Lead
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use update() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->update($lead);
    }

    /**
     * Deletes the given lead.
     *
     * @param string $id The ID of the lead to delete
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use delete() instead
     */
    public function deleteLead(string $id): void
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use delete() instead.', __METHOD__), E_USER_DEPRECATED);

        $this->client->delete($this->prepareUrlForKey('delete-lead', ['id' => $id]));
    }

    /**
     * @param Lead $lead
     *
     * @throws InvalidNewLeadPropertyException
     */
    public function validateLeadForPost(Lead $lead)
    {
        $invalidProperties = ['id', 'tasks', 'opportunities'];
        foreach ($invalidProperties as $invalidProperty) {
            $getter = 'get' . ucfirst($invalidProperty);
            if ($lead->$getter()) {
                throw new InvalidNewLeadPropertyException('Cannot post ' . $invalidProperty . ' to new lead.');
            }
        }
    }
}
