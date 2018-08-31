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
use LooplineSystems\CloseIoApiWrapper\Library\Exception\BadApiRequestException;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\ResourceNotFoundException;
use LooplineSystems\CloseIoApiWrapper\Model\CustomField;

class CustomFieldApi extends AbstractApi
{
    /**
     * The maximum number of items that are requested by default
     */
    private const MAX_ITEMS_PER_REQUEST = 100;

    protected function initUrls()
    {
        $this->urls = [
            'get-custom-fields' => '/custom_fields/lead/',
            'get-custom-field' => '/custom_fields/lead/[:id]/',
            'create-custom-field' => '/custom_fields/lead/',
            'update-custom-field' => '/custom_fields/lead/[:id]/',
            'delete-custom-field' => '/custom_fields/lead/[:id]/',
        ];
    }

    /**
     * Gets up to the specified number of custom fields that match the given
     * criteria.
     *
     * @param int      $offset The offset from which start getting the items
     * @param int      $limit  The maximum number of items to get
     * @param string[] $fields The subset of fields to get (defaults to all)
     *
     * @return CustomField[]
     */
    public function list(int $offset = 0, int $limit = self::MAX_ITEMS_PER_REQUEST, array $fields = []): array
    {
        /** @var CustomField[] $customFields */
        $customFields = [];
        $response = $this->client->get($this->prepareUrlForKey('get-custom-fields'), [
            '_skip' => $offset,
            '_limit' => $limit,
            '_fields' => $fields,
        ]);

        if (200 === $response->getHttpStatusCode() && !$response->isError()) {
            $responseData = $response->getDecodedBody();

            foreach ($responseData['data'] as $customField) {
                $customFields[] = new CustomField($customField);
            }
        }

        return $customFields;
    }

    /**
     * Gets the information about the custom field that matches the given ID.
     *
     * @param string   $id     The ID of the custom field
     * @param string[] $fields The subset of fields to get (defaults to all)
     *
     * @return CustomField
     *
     * @throws ResourceNotFoundException If a custom field with the given ID
     *                                   doesn't exists
     */
    public function get(string $id, array $fields = []): CustomField
    {
        $response = $this->client->get($this->prepareUrlForKey('get-custom-field', ['id' => $id]), ['_fields' => $fields]);

        if (200 === $response->getHttpStatusCode() && !$response->isError()) {
            return new CustomField($response->getDecodedBody());
        }

        throw new ResourceNotFoundException();
    }

    /**
     * Creates a new custom field using the given information.
     *
     * @param CustomField $customField The information of the custom field to create
     *
     * @return CustomField
     *
     * @throws BadApiRequestException If the request contained invalid data
     */
    public function create(CustomField $customField): CustomField
    {
        $response = $this->client->post($this->prepareUrlForKey('create-custom-field'), $customField->jsonSerialize());
        $responseData = $response->getDecodedBody();

        if (200 === $response->getHttpStatusCode() && !$response->isError()) {
            return new CustomField($responseData);
        }

        throw new BadApiRequestException($responseData['error']);
    }

    /**
     * Updates the given custom field.
     *
     * @param CustomField $customField The custom field to update
     *
     * @return CustomField
     *
     * @throws ResourceNotFoundException If a custom field with the given ID
     *                                   doesn't exists
     * @throws BadApiRequestException    If the request contained invalid data
     */
    public function update(CustomField $customField): CustomField
    {
        $id = $customField->getId();

        $customField->setId(null);

        $response = $this->client->put($this->prepareUrlForKey('update-custom-field', ['id' => $id]), $customField->jsonSerialize());
        $responseData = $response->getDecodedBody();

        if (200 === $response->getHttpStatusCode() && !$response->isError()) {
            return new CustomField($responseData);
        }

        throw new BadApiRequestException($responseData['error']);
    }

    /**
     * Deletes the given custom field.
     *
     * @param CustomField $customField The custom field to delete
     */
    public function delete(CustomField $customField): void
    {
        $id = $customField->getId();

        $customField->setId(null);

        $this->client->delete($this->prepareUrlForKey('delete-custom-field', ['id' => $id]));
    }

    /**
     * Gets all the custom fields of the organization to which the user making
     * the request belongs to.
     *
     * @return CustomField[]
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use list() instead
     */
    public function getAllCustomFields(): array
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use list() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->list();
    }

    /**
     * Updates the given custom field.
     *
     * @param CustomField $customField The custom field to update
     *
     * @return CustomField
     *
     * @throws ResourceNotFoundException If a custom field with the given ID
     *                                   doesn't exists
     *
     * @deprecated since version 0.8, to be removed in 0.9. Use update() instead
     */
    public function updateCustomField(CustomField $customField): CustomField
    {
        @trigger_error(sprintf('The %s() method is deprecated since version 0.8. Use update() instead.', __METHOD__), E_USER_DEPRECATED);

        return $this->update($customField);
    }
}
