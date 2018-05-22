<?php
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
use LooplineSystems\CloseIoApiWrapper\Library\Curl\Curl;
use LooplineSystems\CloseIoApiWrapper\Library\Exception\InvalidParamException;
use LooplineSystems\CloseIoApiWrapper\Model\CustomField;

class CustomFieldApi extends AbstractApi
{
    const NAME = 'CustomFieldApi';

    protected function initUrls()
    {
        $this->urls = [
            'get-customFields' => '/custom_fields/lead/',
            'update-customField' => '/custom_fields/lead/[:id]/'
        ];
    }

    /**
     * @param Curl $curl
     */
    public function setCurl($curl)
    {
        $this->curl = $curl;
    }

    /**
     * @return CustomField[]
     */
    public function getAllCustomFields()
    {
        /** @var CustomField[] $customFields */
        $customFields = [];

        $apiRequest = $this->prepareRequest('get-customFields');

        $result = $this->triggerGet($apiRequest);

        if ($result->getReturnCode() == 200) {
            $rawData = $result->getData()[CloseIoResponse::GET_RESPONSE_DATA_KEY];

            foreach ($rawData as $customField) {
                $customFields[] = new CustomField($customField);
            }
        }
        return $customFields;
    }

    /**
     * @param CustomField $customField
     *
     * @return CustomField
     * @throws InvalidParamException
     */
    public function updateCustomField(CustomField $customField)
    {
        if ($customField->getId() == null) {
            throw new InvalidParamException('When updating a custom field you must provide the custom field ID');
        }
        $id = $customField->getId();
        $customField->setId(null);

        $customField = json_encode($customField);
        $apiRequest = $this->prepareRequest('update-customField', $customField, ['id' => $id]);
        $response = $this->triggerPut($apiRequest);

        return new CustomField($response->getData());
    }
}
